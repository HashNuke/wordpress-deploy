FROM python:3.11.3-slim-bullseye

RUN apt update && \
    apt install -y openssh-client && \
    rm -rf /var/lib/apt/lists/*

RUN pip install --upgrade pip && \
    pip install ansible==7.6.0 && \
    pip install ansible==7.6.0 pyyaml==6.0

RUN mkdir -p /run/host-services/

COPY . /app
WORKDIR /app

ENTRYPOINT ["/bin/bash", "/app/scripts/docker-entrypoint.sh"]
CMD ["setup.yml"]
