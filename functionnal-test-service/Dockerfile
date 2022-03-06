FROM golang:alpine

# Enable Go modules
ENV GO111MODULE=on

# Move to working directory /app
WORKDIR /app

# Copy the code into the container
COPY . .

# Install 'air' live-reload go module
RUN go get -u github.com/cosmtrek/air

# Run the excutable
ENTRYPOINT ["/go/bin/air"]