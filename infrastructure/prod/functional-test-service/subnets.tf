resource "aws_default_subnet" "default_subnet_a" {
  availability_zone = "eu-west-3a"
}

resource "aws_default_subnet" "default_subnet_b" {
  availability_zone = "eu-west-3b"
}

resource "aws_default_subnet" "default_subnet_c" {
  availability_zone = "eu-west-3c"
}