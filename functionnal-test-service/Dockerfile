FROM golang:1.17.0-alpine

RUN apk update && apk upgrade && \
    apk add --no-cache bash git openssh

WORKDIR /app

COPY ./go.mod ./go.sum ./

RUN go mod download

COPY . .

RUN go get

RUN go mod vendor

RUN go build -o main .


CMD ["./main"]
