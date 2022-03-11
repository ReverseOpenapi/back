variable "region" {
  type        = string
  description = "This is the cloud hosting region where the service will be deployed."
}

variable "prefix" {
  type        = string
  default     = "prod"
  description = "This is the environment where the service is deployed. test, prod, or dev"
}

variable "app_env" {
  type        = string
  default     = "dev"
  description = "Symfony's configuration environments"
}
variable "database_url" {
  type = string
}

variable "sqs_transport_dsn" {
  type = string
}

variable "sqs_dlq_transport_dsn" {
  type        = string
  description = "DSN of the failed queue"
}

variable "s3_key" {
  type        = string
  description = "Key of IAM user"
}

variable "s3_secret" {
  type        = string
  description = "Private key of IAM user"
}

variable "s3_version" {
  type = string
}

variable "s3_region" {
  type        = string
  description = "Bucket region"
}

variable "s3_bucket" {
  type        = string
  description = "Bucket name"
}