output "sqs_openapi_service_url" {
  description = "URL of openapi-service queue"
  value       = aws_sqs_queue.openapi_service.url
}

output "sqs_functional_test_service_url" {
  description = "URL of functional-test-service queue"
  value       = aws_sqs_queue.functional_test_service.url
}

#output "sqs_sql_fixtures_service_url" {
#  description = "URL of sql-fixtures-service queue"
#  value       = aws_sqs_queue.sql_fixtures_service.url
#}

output "rds_endpoint" {
  description = "URL of the database"
  value       = aws_db_instance.reverse_openapi.endpoint
}

output "s3_bucket" {
  description = "Bucket to connect to"
  value       = aws_s3_bucket.reverse_openapi.bucket
}
