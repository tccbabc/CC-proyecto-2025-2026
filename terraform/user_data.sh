#!/bin/bash
set -e

# 1. Update system
apt-get update -y

# 2. Install required packages
apt-get install -y \
  docker.io \
  git \
  curl

# 3. Enable and start Docker
systemctl enable docker
systemctl start docker

# 4. Install docker-compose plugin
mkdir -p /usr/local/lib/docker/cli-plugins
curl -SL https://github.com/docker/compose/releases/download/v2.25.0/docker-compose-linux-x86_64 \
  -o /usr/local/lib/docker/cli-plugins/docker-compose
chmod +x /usr/local/lib/docker/cli-plugins/docker-compose

# 5. Allow ubuntu user to run docker
usermod -aG docker ubuntu

# 6. Switch to ubuntu user and deploy the project
su - ubuntu <<'EOF'
cd /home/ubuntu

# ⚠️ REPLACE THIS WITH YOUR REAL REPOSITORY URL
git clone https://github.com/tccbabc/CC-proyecto-2025-2026.git project
cd project

# Start the application (same as local)
docker compose up -d --build
EOF
