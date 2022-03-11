resource "aws_ecr_repository" "reverse_openapi" {
  name = "${var.prefix}-functional-test-service"
}