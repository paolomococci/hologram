# Generic Dockerfile with step-by-step comments

Below are some examples that are useful especially as drafts for later development.

## 1. Web API - ASP.NET Core (C#)

```dockerfile
# -----------------------------
#  Base image for development with the .NET 8 SDK
# -----------------------------

# Of course, the name of the image and its availability remains at the discretion of the organization making it available.
FROM debian:bookworm-slim AS build

# 1. Updating core packages and installing wget
RUN apt update && apt upgrade -y && apt autoremove -y
RUN apt-get install -y wget

# 2. Adding the Microsoft repository for Debian 12
# Of course, the following URL can change arbitrarily at the discretion of the entity that makes it available.
RUN wget https://packages.microsoft.com/config/debian/12/packages-microsoft-prod.deb -O packages-microsoft-prod.deb
RUN dpkg -i packages-microsoft-prod.deb
RUN rm packages-microsoft-prod.deb

# 3. Installing the .NET 8 SDK, required for the build
RUN apt-get update && \
    apt-get install -y --no-install-recommends dotnet-sdk-8.0 aspnetcore-runtime-8.0 && \
    apt-get clean

# 4. Now I define, by moving to it, a working directory
WORKDIR /workbench

# 5. Copying the solution and project files for the upcoming restore
COPY ["./GenericSolution.sln", "./"]
COPY ["./src/GenericAPIProject/GenericAPIProject.csproj", "./src/GenericAPIProject/"]

# 6. Restore dependencies, just the solution not the code
RUN dotnet restore "GenericSolution.sln"

# 7. Copy the rest of the source code
COPY . .

# 8. Build the complete solution in Release mode
RUN dotnet publish "GenericSolution.sln" -c Release --no-restore --output /app

# -----------------------------
#  Stage 2 - runtime (final image)
# -----------------------------
FROM build AS runtime

# 9. Removing the .NET SDK, after this step only the necessary runtime will remain
RUN apt-get purge -y dotnet-sdk-8.0 && \
    apt-get autoremove -y && apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# 10. Working directory for the application
WORKDIR /app

# 11. Creating a non-root user to run the application
RUN useradd deployer && chown -R deployer:deployer /app

# 12. Copy of the application built from the build image
COPY --from=build /app .

# 13. Environment configuration that can later be overridden at runtime
ENV ASPNETCORE_ENVIRONMENT=Development
ENV ASPNETCORE_URLS=http://+:9000

# 14. Port 9000 exposure which can later be mapped by the orchestrator
EXPOSE 9000

# 15. Starting the application as the deployer user, that is, a non-root user
USER deployer
ENTRYPOINT ["dotnet", "GenericAPIProject.dll"]
```

---

## 2. Web UI - ASP.NET Core (C#)

```dockerfile
# -----------------------------
#  Base image for development with the .NET 8 SDK
# -----------------------------

# Of course, the name of the image and its availability remains at the discretion of the organization making it available.
FROM debian:bookworm-slim AS build

# 1. Updating core packages and installing wget
RUN apt update && apt upgrade -y && apt autoremove -y
RUN apt-get install -y wget

# 2. Adding the Microsoft repository for Debian 12
# Of course, the following URL can change arbitrarily at the discretion of the entity that makes it available.
RUN wget https://packages.microsoft.com/config/debian/12/packages-microsoft-prod.deb -O packages-microsoft-prod.deb
RUN dpkg -i packages-microsoft-prod.deb
RUN rm packages-microsoft-prod.deb

# 3. Installing the .NET 8 SDK, required for the build
RUN apt-get update && \
    apt-get install -y --no-install-recommends dotnet-sdk-8.0 aspnetcore-runtime-8.0 && \
    apt-get clean

# 4. Working directory, precisely
WORKDIR /workbench

# 5.Copying solution and project files for restore
COPY ["./GenericSolution.sln", "./"]
COPY ["./src/GenericUIProject/GenericUIProject.csproj", "./src/GenericUIProject/"]

# 6. Restore dependencies, just the solution not the code
RUN dotnet restore "GenericSolution.sln"

# 7. Copy the rest of the source code, after the restore to not overwrite the locks
COPY . .

# 8. Build the complete solution in Release mode
RUN dotnet publish "GenericSolution.sln" -c Release --no-restore --output /app

# -----------------------------
#  Stage 2 - runtime (final image)
# -----------------------------
FROM build AS runtime

# 9. Removing the .NET SDK, after this step only the necessary runtime will remain
RUN apt-get purge -y dotnet-sdk-8.0 && \
    apt-get autoremove -y && apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# 10. Working directory for the application
WORKDIR /app

# 11. Creating a non-root user to run the application
RUN useradd deployer && chown -R deployer:deployer /app

# 12. Copy of the application built from the build image
COPY --from=build /app .

# 13. Environment configuration that can later be overridden at runtime
ENV ASPNETCORE_ENVIRONMENT=Development
ENV ASPNETCORE_URLS=http://+:9002

# 14. Port 9002 exposure which can later be mapped by the orchestrator
EXPOSE 9002

# 15. Starting the application as the deployer user, that is, a non-root user
USER deployer
ENTRYPOINT ["dotnet", "GenericUIProject.dll"]
```

---

## 3. Web API - Go

```dockerfile
# -----------------------------
#  Multi-stage build for the Go programming language
# -----------------------------

# Of course, the name of the image and its availability remains at the discretion of the organization making it available.
FROM golang:tip-20250815-bookworm AS builder

# 1. Setting the working directory
WORKDIR /app

# 2. Copying dependency files
COPY go.mod go.sum ./

# 3. Downloading dependencies
RUN go mod download

# 4. Copy of the entire source code
COPY . .

# 5. Compiling the executable, the output is called "webapi"
RUN go build -o webapi .

# -----------------------------
#  Deployment stage - runtime
# -----------------------------

# Of course, the name of the image and its availability remains at the discretion of the organization making it available.
FROM debian:bookworm-20250811-slim

# 6. Copying the executable from builder
COPY --from=builder /app/webapi /usr/local/bin/webapi

# 7. Service door exposure
EXPOSE 8080

# 8. Running the application
CMD ["webapi"]
```
