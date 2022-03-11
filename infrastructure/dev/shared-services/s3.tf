resource "aws_s3_bucket" "reverse_openapi" {
  bucket        = "${var.prefix}-reverseopenapi"
  force_destroy = true
}