terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 3.27"
    }
  }

  backend "s3" {
    bucket = "reverseopenapi-tfstate"
    key    = "prod/openapi-service/terraform.tfstate"
    region = "eu-west-3"
  }

  required_version = ">= 0.14.9"
}

provider "aws" {
  profile = "reverseopenapi" // make sure you have configured aws cli with the associated profile
  region  = "eu-west-3"
}