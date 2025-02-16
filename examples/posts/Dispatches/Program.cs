using Microsoft.AspNetCore.HttpOverrides;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.

builder.Services.AddControllers();
// Learn more about configuring OpenAPI at https://aka.ms/aspnet/openapi
builder.Services.AddOpenApi();

var app = builder.Build();

// middleware that makes it possible to use reverse proxy
app.UseForwardedHeaders(
    new ForwardedHeadersOptions {
        ForwardedHeaders = ForwardedHeaders.XForwardedFor | ForwardedHeaders.XForwardedProto
    });


// Configure the HTTP request pipeline.
if (app.Environment.IsDevelopment())
{
    app.MapOpenApi();
}

if (!app.Environment.IsDevelopment()) {
    app.UseHttpsRedirection();
}

app.UseHttpsRedirection();

app.UseAuthorization();

app.MapControllers();

// simply responds with a message to a request similar to the following:
// http://192.168.XXX.XXX:8080/api/echo/hello/John%20J.%20Doe
app.MapGet(
    "/api/echo/hello/{name}", 
    (string name) => $"{{'message': 'Hello, {name}!'}}"
);

// responds by showing the result just computed to a request similar to the following:
// http://192.168.XXX.XXX:8080/api/echo/cube/7
app.MapGet(
    "/api/echo/cube/{number}", 
    (int number) => $"{{'cube': {number*number*number}'}}"
);

app.Run();
