resource "aws_ecs_cluster" "reverse_openapi" {
  name = "${var.prefix}-reverse-openapi"
}

resource "aws_ecs_service" "reverse_openapi" {
  name            = "${var.prefix}-openapi-service"
  cluster         = aws_ecs_cluster.reverse_openapi.arn
  task_definition = aws_ecs_task_definition.reverse_openapi.arn
  desired_count   = 1
  launch_type     = "FARGATE"

  network_configuration {
    subnets = [
      aws_default_subnet.default_subnet_a.id,
      aws_default_subnet.default_subnet_b.id,
      aws_default_subnet.default_subnet_c.id
    ]
    assign_public_ip = true
  }
}

resource "aws_ecs_task_definition" "reverse_openapi" {
  family                   = "${var.prefix}-openapi-service"
  requires_compatibilities = ["FARGATE"]
  network_mode             = "awsvpc"
  execution_role_arn       = aws_iam_role.ecs_task_execution_role.arn
  memory                   = 512
  cpu                      = 256
  container_definitions = jsonencode([
    {
      name      = "${var.prefix}-openapi-service"
      image     = aws_ecr_repository.reverse_openapi.repository_url
      cpu       = 256
      memory    = 512
      essential = true
    },
  ])
}