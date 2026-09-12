# Traefik reverse proxy

This project runs [Traefik](https://traefik.io/) as a Docker-based reverse proxy and edge router.

## Stack

- **Traefik `v3.7.11`**: discovers Docker services and routes requests according to their Docker labels.
- **Docker provider**: enabled through the read-only Docker socket mount at `/var/run/docker.sock`.
- **Docker Compose**: starts and builds the Traefik service from `traefik.yaml`.
- **External Docker network**: services that should be routed by Traefik must join the `proxy-net` network.
- **Entrypoints**:
  - HTTP on port `80` (`web`), redirected to HTTPS.
  - HTTPS on port `443` (`websecure`).
  - Traefik dashboard/API on port `8080` with the current insecure API setting.

Traefik does not expose Docker services by default. Applications must opt in through their Traefik labels. The `proxy-net` network must exist before starting the stack.

## Prerequisites

- Docker Engine
- Docker Compose v2, or a Docker installation with `docker compose`
- Permission to access Docker and ports `80`, `443`, and `8080`

## Makefile commands

Run commands from the project directory with `make <target>`.

| Command | Description |
| --- | --- |
| `make init` | Create the external Docker network named `proxy-net`. Run this once before `make start`. |
| `make start` | Start the Traefik Compose stack in detached mode and force recreation of containers. |
| `make build` | Build the Compose services and remove intermediate containers after the build. |
| `make stop` | Stop every container returned by `docker ps -aq` on the host. |
| `make kill` | Run Docker cleanup commands: `docker system prune`, `docker network prune`, and `docker volume prune`. Docker may ask for confirmation. |

## Typical setup

```bash
make init
make start
```

To rebuild the stack:

```bash
make build
make start
```

The dashboard/API is available at `http://localhost:8080` when the stack is running. The insecure API setting is intended for local use only; secure and authenticated dashboard access should be configured before exposing it outside a trusted environment.
