# Kubernetes Deployment Guide

This guide will help you deploy the Attendance System to Kubernetes.

## Prerequisites

- Docker Desktop with Kubernetes enabled
- kubectl installed and configured
- All files in this directory

## Quick Start

### Option 1: Automated Setup (Recommended for Windows)

Run the PowerShell script:

```powershell
.\k8s-setup.ps1
```

### Option 2: Manual Setup

#### Step 1: Build Docker Image

```powershell
docker build -t attendance-system-web:latest .
```

#### Step 2: Deploy Database

```powershell
kubectl apply -f db.yaml
```

Wait for database to be ready:

```powershell
kubectl wait --for=condition=ready pod -l app=mysql --timeout=120s
```

#### Step 3: Deploy Web Application

```powershell
kubectl apply -f web-deployment.yaml
```

#### Step 4: Deploy PHPMyAdmin

```powershell
kubectl apply -f phpmyadmin-deployment.yaml
```

## Accessing the Application

### Method 1: Port Forwarding (Recommended)

**Web Application:**
```powershell
kubectl port-forward service/web 8085:80
```
Then open: http://localhost:8085

**PHPMyAdmin:**
```powershell
kubectl port-forward service/phpmyadmin 8086:80
```
Then open: http://localhost:8086

### Method 2: NodePort (Check assigned ports)

```powershell
kubectl get svc web phpmyadmin
```

Look for the NodePort column and access via `localhost:<NodePort>`

## Useful Kubernetes Commands

### Check Status

```powershell
# View all deployments
kubectl get deployments

# View all services
kubectl get services

# View all pods
kubectl get pods

# View detailed pod information
kubectl describe pod <pod-name>
```

### View Logs

```powershell
# View logs for web pods
kubectl logs -l app=web

# View logs for database
kubectl logs -l app=mysql

# View logs for PHPMyAdmin
kubectl logs -l app=phpmyadmin

# Follow logs in real-time
kubectl logs -f -l app=web
```

### Scaling

```powershell
# Scale web application to 3 replicas
kubectl scale deployment web --replicas=3

# Scale web application to 1 replica
kubectl scale deployment web --replicas=1
```

### Troubleshooting

```powershell
# Describe a pod to see events
kubectl describe pod <pod-name>

# Execute commands in a pod
kubectl exec -it <pod-name> -- bash

# Access MySQL database
kubectl exec -it $(kubectl get pod -l app=mysql -o jsonpath='{.items[0].metadata.name}') -- mysql -u annisa -p12345 attendance_system
```

### Delete Resources

```powershell
# Delete specific resources
kubectl delete -f web-deployment.yaml
kubectl delete -f phpmyadmin-deployment.yaml
kubectl delete -f db.yaml

# Delete all resources at once
kubectl delete -f .
```

## File Structure

- `db.yaml` - Database deployment, service, PVC, and ConfigMap
- `web-deployment.yaml` - Web application deployment and service
- `phpmyadmin-deployment.yaml` - PHPMyAdmin deployment and service
- `k8s-setup.ps1` - Automated setup script for Windows
- `k8s-setup.sh` - Automated setup script for Linux/Mac

## Configuration Details

### Database
- **Image**: mysql:8.0
- **Database**: attendance_system
- **User**: annisa
- **Password**: 12345
- **Root Password**: root
- **Service Name**: db (used by other pods)

### Web Application
- **Image**: attendance-system-web:latest (built from Dockerfile)
- **Replicas**: 2
- **Service Type**: NodePort
- **Port**: 80

### PHPMyAdmin
- **Image**: phpmyadmin/phpmyadmin:latest
- **Service Type**: NodePort
- **Port**: 80

## Troubleshooting

### Pods Not Starting

1. Check pod status:
   ```powershell
   kubectl get pods
   kubectl describe pod <pod-name>
   ```

2. Check logs:
   ```powershell
   kubectl logs <pod-name>
   ```

### Database Connection Issues

1. Verify database pod is running:
   ```powershell
   kubectl get pods -l app=mysql
   ```

2. Check database logs:
   ```powershell
   kubectl logs -l app=mysql
   ```

3. Verify service exists:
   ```powershell
   kubectl get svc db
   ```

### Image Pull Errors

If you see image pull errors for `attendance-system-web:latest`:

1. Verify image exists:
   ```powershell
   docker images | Select-String "attendance-system-web"
   ```

2. Rebuild and ensure it's available:
   ```powershell
   docker build -t attendance-system-web:latest .
   ```

3. For Docker Desktop, images are automatically available to Kubernetes

### Reset Everything

To completely reset the Kubernetes deployment:

```powershell
kubectl delete -f web-deployment.yaml
kubectl delete -f phpmyadmin-deployment.yaml
kubectl delete -f db.yaml
```

Then run the setup script again.

