variable "region" {
  type        = string
  description = "This is the cloud hosting region where the service will be deployed."
}

variable "prefix" {
  type        = string
  default     = "dev"
  description = "This is the environment where the service is deployed. qa, prod, or dev"
}

variable "db_username" {
  type        = string
  description = "Username for the master DB user"
  sensitive   = true
}

variable "db_password" {
  type        = string
  description = "Password for the master DB user"
  sensitive   = true
}