resource "aws_sqs_queue" "openapi_service" {
  name = "${var.prefix}-openapi-service"
}

resource "aws_sqs_queue" "functional_test_service" {
  name = "${var.prefix}-functional_test_service"
}

#resource "aws_sqs_queue" "sql-fixtures-service" {
#  name = "${var.prefix}-sql-fixtures-services"
#}