variable "region" {
  type        = string
  description = "This is the cloud hosting region where the service will be deployed."
}

variable "prefix" {
  type        = string
  default     = "prod"
  description = "This is the environment where the service is deployed. qa, prod, or dev"
}