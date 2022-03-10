resource "aws_db_instance" "reverse_openapi" {
  allocated_storage   = 20
  engine              = "mysql"
  engine_version      = "8.0.27"
  instance_class      = "db.t2.micro"
  identifier          = "${var.prefix}-reverseopenapi"
  username            = var.db_username
  password            = var.db_password
  publicly_accessible = true
  skip_final_snapshot = true
}