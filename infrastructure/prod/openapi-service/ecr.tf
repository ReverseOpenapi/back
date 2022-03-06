resource "aws_ecr_repository" "reverse_openapi" {
  name = "${var.prefix}-openapi-service"
}