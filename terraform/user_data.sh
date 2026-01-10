#!/bin/bash
set -e

apt-get update -y
apt-get install -y docker.io git curl

systemctl enable docker
systemctl start docker

mkdir -p /usr/local/lib/docker/cli-plugins
curl -SL https://github.com/docker/compose/releases/download/v2.25.0/docker-compose-linux-x86_64 \
  -o /usr/local/lib/docker/cli-plugins/docker-compose
chmod +x /usr/local/lib/docker/cli-plugins/docker-compose

usermod -aG docker ubuntu

su - ubuntu <<'EOF'
cd /home/ubuntu
git clone https://github.com/tccbabc/CC-proyecto-2025-2026.git project
cd project
docker compose up -d --build
EOF
