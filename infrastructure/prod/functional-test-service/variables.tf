variable "region" {
  type        = string
  description = "This is the cloud hosting region where the service will be deployed."
}

variable "prefix" {
  type        = string
  default     = "prod"
  description = "This is the environment where the service is deployed. test, prod, or dev"
}

variable "DB_PASSWORD" {
  type = string
}

variable "DB_HOSTS" {
  type = string
}

variable "DB_USER" {
  type = string
}

variable "DB_PORT" {
  type = string
}

variable "DB_NAME" {
  type = string
}

variable "AWS_ACCESS_KEY_ID" {
  type = string
}

variable "AWS_SECRET_ACCESS_KEY" {
  type = string
}

variable "AWS_LOAD_CONFIG" {
  type = string
}

variable "SQS_QUEUE" {
  type = string
}