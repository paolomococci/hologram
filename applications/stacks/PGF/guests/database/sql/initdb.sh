#!/bin/bash
set -euo pipefail

# create guests_db if it does not already exist
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<'EOSQL'
create database guests_db;
EOSQL

# opens a new connection directly to guests_db
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname=guests_db <<'EOSQL'

-- create extension pgcrypto
create extension if not exists pgcrypto;

-- create a schema named as guests_sc
create schema if not exists guests_sc;

-- creates the guests_sc.guests table
create table if not exists guests_sc.guests (
    id uuid primary key default gen_random_uuid(),
    name varchar(64) not null,
    email varchar(64) not null unique,
    password_hash text not null,
    role varchar(64) not null default 'staffer',
    created_at timestamptz not null default now(),
    updated_at timestamptz not null default now()
);

-- function that updates the value assigned to updated_at
create or replace function guests_sc.update_updated_at_column()
returns trigger as $$
begin
    new.updated_at = now();
    return new;
end;
$$ language plpgsql;

-- create a trigger, the trigger name can be left without a schema
create trigger set_updated_at
before update on guests_sc.guests
for each row
-- schema qualification mandatory here
execute function guests_sc.update_updated_at_column();

-- helper for idempotent creating guests and bcrypt with configurable cost
create or replace function guests_sc.create_user(
    p_name varchar,
    p_email varchar,
    p_password text,
    p_role varchar default 'staffer',
    p_cost integer default 14
) returns void language plpgsql as $$
begin
    insert into guests_sc.guests (name, email, password_hash, role)
    values (p_name, p_email, crypt(p_password, gen_salt('bf', p_cost)), p_role)
    on conflict (email) do nothing;
end;
$$;

-- function that extracts the cost/work factor from a bcrypt hash
create or replace function guests_sc.bcrypt_cost_from_hash(p_hash text)
returns integer language sql immutable as $$
    select (regexp_matches(p_hash, '\$2[aby]?\$(\d{2})\$'))[1]::int
$$;

-- function that verifies credentials, to call during the login flow, for example: guests_sc.verify_and_maybe_rehash(email, password)
-- If the password is correct, it returns id;
-- furthermore, if the cost of the stored hash is less than the target p_target_cost, it recalculates the hash with the new cost and updates the record (re-hash on login).
create or replace function guests_sc.verify_and_maybe_rehash(
    p_email varchar,
    p_password text,
    p_target_cost integer default 14
) returns integer language plpgsql as $$
declare
    v_id integer;
    v_hash text;
    v_cost integer;
    v_new_hash text;
begin
    select id, password_hash into v_id, v_hash
    from guests_sc.guests
    where email = p_email;

    if v_id is null then
        return null;
    end if;

    -- verify password, crypt with stored hash
    if v_hash = crypt(p_password, v_hash) then
        -- correct password: check current cost
        begin
            v_cost := guests_sc.bcrypt_cost_from_hash(v_hash);
        exception when others then
            -- if parsing fails, force the hash king
            v_cost := null;
        end;

        if v_cost is null or v_cost < p_target_cost then
            -- calculate hash with new salt and cost
            v_new_hash := crypt(p_password, gen_salt('bf', p_target_cost));
            UPDATE guests_sc.guests
            SET password_hash = v_new_hash,
                    updated_at = now()
            where id = v_id;
        end if;

        return v_id;
    else
        return null;
    end if;
end;
$$;

-- populates the guests_sc.guests table with test data

-- group insertion method
with vals(name, email, password_hash, role) as (
        values
        ('Oliver', 'oliver@example.local', 'OliverPa55w0r4', 'operator'),
        ('Dorothy', 'dorothy@example.local', 'DorothyPa55w0r4', 'staffer'),
        ('Charlotte', 'charlotte@example.local', 'CharlottePa55w0r4', 'staffer'),
        ('Harry', 'harry@example.local', 'HarryPa55w0r4', 'lead'),
        ('Amelia', 'amelia@example.local', 'AmeliaPa55w0r4', 'admin'),
        ('Jack', 'jack@example.local', 'JackPa55w0r4', 'lead'),
        ('Olivia', 'olivia@example.local', 'OliviaPa55w0r4', 'lead'),
        ('George', 'george@example.local', 'GeorgePa55w0r4', 'operator'),
        ('Isla', 'isla@example.local', 'IslaPa55w0r4', 'staffer'),
        ('Noah', 'noah@example.local', 'NoahPa55w0r4', 'staffer'),
        ('Mia', 'mia@example.local', 'MiaPa55w0r4', 'staffer'),
        ('Leo', 'leo@example.local', 'LeoPa55w0r4', 'lead'),
        ('Sophia', 'sophia@example.local', 'SophiaPa55w0r4', 'operator'),
        ('Emily', 'emily@example.local', 'EmilyPa55w0r4', 'admin'),
        ('Henry', 'henry@example.local', 'HenryPa55w0r4', 'staffer'),
        ('Sophie', 'sophie@example.local', 'SophiePa55w0r4', 'operator'),
        ('Freddie', 'freddie@example.local', 'FreddiePa55w0r4', 'staffer'),
        ('Lily', 'lily@example.local', 'LilyPa55w0r4', 'operator'),
        ('Thomas', 'thomas@example.local', 'ThomasPa55w0r4', 'staffer'),
        ('Grace', 'grace@example.local', 'GracePa55w0r4', 'staffer'),
        ('William', 'william@example.local', 'WilliamPa55w0r4', 'staffer'),
        ('James', 'james@example.local', 'JamesPa55w0r4', 'lead'),
        ('Ava', 'ava@example.local', 'AvaPa55w0r4', 'lead'),
        ('Samuel', 'samuel@example.local', 'SamuelPa55w0r4', 'admin'),
        ('Ella', 'ella@example.local', 'EllaPa55w0r4', 'staffer'),
        ('Benjamin', 'benjamin@example.local', 'BenjaminPa55w0r4', 'operator'),
        ('Abigail', 'abigail@example.local', 'AbigailPa55w0r4', 'staffer'),
        ('John', 'john@example.local', 'JohnPa55w0r4', 'staffer'),
        ('Joshua', 'joshua@example.local', 'JoshuaPa55w0r4', 'admin'),
        ('Chloe', 'chloe@example.local', 'ChloePa55w0r4', 'operator'),
        ('Joseph', 'joseph@example.local', 'JosephPa55w0r4', 'lead'),
        ('Zoe', 'zoe@example.local', 'ZoePa55w0r4', 'staffer'),
        ('Daniel', 'daniel@example.local', 'DanielPa55w0r4', 'staffer'),
        ('Hannah', 'hannah@example.local', 'HannahPa55w0r4', 'lead'),
        ('Lea', 'lea@example.local', 'LeaPa55w0r4', 'operator')
) select guests_sc.create_user(name, email, password_hash, role) from vals;

-- simple method using repeated select batches
select guests_sc.create_user('Michael', 'michael@example.local', 'MichaelPa55w0r4', 'lead');
select guests_sc.create_user('Mikey', 'mikey@example.local', 'MikeyPa55w0r4', 'admin');

-- direct entry method
insert into guests_sc.guests (name, email, password_hash, role) values 
    ('Jake', 'jake@example.local', crypt('JakePa55w0r4', gen_salt('bf',14)), 'admin'),
    ('Liam', 'liam@example.local', crypt('LiamPa55w0r4', gen_salt('bf',14)), 'staffer'),
    ('Damian', 'damian@example.local', crypt('DamianPa55w0r4', gen_salt('bf',14)), 'lead')
on conflict (email) do nothing;
EOSQL
