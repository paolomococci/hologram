###########################
## first stage – Build    #
###########################
FROM golang:1.25.3-alpine AS builder

# Set the working folder where Go will compile
WORKDIR /src

# Copy only dependency configuration files
COPY src/go.mod ./

# Copy, if present, file generated with shell command line: `cd src/ && go mod tidy`
COPY src/go.sum ./

# To download dependencies you need a valid go.mod
RUN go mod download

# Copy the rest of the project
COPY src/ ./

# Compile the executable with minimized flags
RUN CGO_ENABLED=0 GOOS=linux go build \
    -trimpath \
    -ldflags="-s -w" \
    -o /app/main \
    ./...

###########################
## second stage – Runtime #
###########################
FROM scratch

# Copy only the executable from the builder
COPY --from=builder /app/main /app/main

# Expose the port 8080
EXPOSE 8080

# Launch the app
ENTRYPOINT ["/app/main"]