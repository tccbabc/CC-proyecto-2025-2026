variable "aws_region" {
  description = "AWS region where the EC2 instance will be created"
  type        = string
  default     = "eu-north-1"
}

variable "key_name" {
  description = "EC2 SSH key pair name"
  type        = string
}
