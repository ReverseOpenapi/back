resource "aws_sqs_queue" "openapi_service" {
  name = "${var.prefix}-openapi-service"
  redrive_policy = jsonencode({
    deadLetterTargetArn = aws_sqs_queue.openapi_service_DLQ.arn
    maxReceiveCount     = 3
  })
}

resource "aws_sqs_queue" "openapi_service_DLQ" {
  name = "${var.prefix}-openapi-service-DLQ"
}

resource "aws_sqs_queue" "functional_test_service" {
  name = "${var.prefix}-functional-test-service"
  redrive_policy = jsonencode({
    deadLetterTargetArn = aws_sqs_queue.functional_test_service_DLQ.arn
    maxReceiveCount     = 3
  })
}

resource "aws_sqs_queue" "functional_test_service_DLQ" {
  name = "${var.prefix}-functional-test-service-DLQ"
}

#resource "aws_sqs_queue" "sql_fixtures_service" {
#  name = "${var.prefix}-sql-fixtures-services"
#  redrive_policy = jsonencode({
#    deadLetterTargetArn = aws_sqs_queue.sql_fixtures_service_DLQ.arn
#    maxReceiveCount     = 3
#  })
#}
#
#resource "aws_sqs_queue" "sql_fixtures_service_DLQ" {
#  name = "${var.prefix}-sql-fixtures-service-DLQ"
#}