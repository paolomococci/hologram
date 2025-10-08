#!/bin/bash
set -euo pipefail

# create users_db if it does not already exist
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<'EOSQL'
create database users_db;
EOSQL

# opens a new connection directly to users_db
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname=users_db <<'EOSQL'
create schema if not exists users_sc;

-- creates the users_sc.users table
create table if not exists users_sc.users (
    id integer generated always as identity primary key,
    name text not null,
    email text unique,
    role text not null default 'guest',
    created_at timestamptz not null default now(),
    updated_at timestamptz not null default now()
);

-- populates the users_sc.users table with test data
insert into users_sc.users (name, email, role) values
    ('Oliver', 'oliver@example.local', 'operator'),
    ('Dorothy', 'dorothy@example.local', 'guest'),
    ('Charlotte', 'charlotte@example.local', 'guest'),
    ('Harry', 'harry@example.local', 'guest'),
    ('Amelia', 'amelia@example.local', 'admin'),
    ('Jack', 'jack@example.local', 'user'),
    ('Olivia', 'olivia@example.local', 'guest'),
    ('George', 'george@example.local', 'operator'),
    ('Isla', 'isla@example.local', 'user'),
    ('Noah', 'noah@example.local', 'user'),
    ('Mia', 'mia@example.local', 'guest'),
    ('Leo', 'leo@example.local', 'guest'),
    ('Sophia', 'sophia@example.local', 'operator'),
    ('Emily', 'emily@example.local', 'admin'),
    ('Henry', 'henry@example.local', 'guest'),
    ('Sophie', 'sophie@example.local', 'operator'),
    ('Freddie', 'freddie@example.local', 'guest'),
    ('Lily', 'lily@example.local', 'operator'),
    ('Thomas', 'thomas@example.local', 'guest'),
    ('Grace', 'grace@example.local', 'guest'),
    ('William', 'william@example.local', 'guest'),
    ('James', 'james@example.local', 'user'),
    ('Ava', 'ava@example.local', 'guest'),
    ('Samuel', 'samuel@example.local', 'admin'),
    ('Ella', 'ella@example.local', 'user'),
    ('Benjamin', 'benjamin@example.local', 'operator'),
    ('Abigail', 'abigail@example.local', 'guest'),
    ('John', 'john@example.local', 'guest'),
    ('Joshua', 'joshua@example.local', 'admin'),
    ('Chloe', 'chloe@example.local', 'operator'),
    ('Joseph', 'joseph@example.local', 'user'),
    ('Zoe', 'zoe@example.local', 'guest'),
    ('Daniel', 'daniel@example.local', 'user'),
    ('Hannah', 'hannah@example.local', 'guest')
on conflict (email) do nothing;
EOSQL
