resource "aws_ecr_repository" "prod" {
  name = "${var.prefix}-openapi-service"
}