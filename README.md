# Attendance System - Kubernetes

Simple PHP attendance system running on Kubernetes.

## Quick Start

### Start the Application

```powershell
# Build the Docker image
docker build -t attendance-system-web:latest .

# Deploy everything to Kubernetes
kubectl apply -f db.yaml
kubectl apply -f web-deployment.yaml
kubectl apply -f phpmyadmin-deployment.yaml
```

**Or use the automated script:**
```powershell
.\k8s-setup.ps1
```

### Access the Application

**Option 1: Port Forwarding (Recommended)**
```powershell
# Terminal 1 - Web Application
kubectl port-forward service/web 8085:80

# Terminal 2 - PHPMyAdmin
kubectl port-forward service/phpmyadmin 8086:80
```

Then open:
- Web App: http://localhost:8085
- PHPMyAdmin: http://localhost:8086

**Option 2: Direct NodePort**
- Web App: http://localhost:30806
- PHPMyAdmin: http://localhost:30313

## Basic Commands

### Check Status

```powershell
# View all pods
kubectl get pods

# View all services
kubectl get services

# View all deployments
kubectl get deployments
```

### View Logs

```powershell
# Web application logs
kubectl logs -l app=web

# Database logs
kubectl logs -l app=mysql

# PHPMyAdmin logs
kubectl logs -l app=phpmyadmin

# Follow logs in real-time
kubectl logs -f -l app=web
```

### Stop the Application

```powershell
# Stop all deployments (pods will be removed)
kubectl delete -f web-deployment.yaml
kubectl delete -f phpmyadmin-deployment.yaml
kubectl delete -f db.yaml
```

### Pause/Resume

```powershell
# Scale down to 0 (pause)
kubectl scale deployment web --replicas=0
kubectl scale deployment phpmyadmin --replicas=0
kubectl scale deployment db --replicas=0

# Scale back up (resume)
kubectl scale deployment web --replicas=2
kubectl scale deployment phpmyadmin --replicas=1
kubectl scale deployment db --replicas=1
```

### Restart

```powershell
# Restart all pods
kubectl rollout restart deployment/web
kubectl rollout restart deployment/phpmyadmin
kubectl rollout restart deployment/db
```

### Remove Everything

```powershell
# Delete all resources
kubectl delete -f web-deployment.yaml
kubectl delete -f phpmyadmin-deployment.yaml
kubectl delete -f db.yaml
```

## Scaling

```powershell
# Scale web application to 3 replicas
kubectl scale deployment web --replicas=3

# Scale back to 2
kubectl scale deployment web --replicas=2
```

## Troubleshooting

### Pod Not Starting

```powershell
# Check pod status
kubectl describe pod <pod-name>

# View pod logs
kubectl logs <pod-name>
```

### Database Connection Issues

```powershell
# Check if database is running
kubectl get pods -l app=mysql

# Access database directly
kubectl exec -it $(kubectl get pod -l app=mysql -o jsonpath='{.items[0].metadata.name}') -- mysql -u annisa -p12345 attendance_system
```

### Rebuild After Code Changes

```powershell
# Rebuild Docker image
docker build -t attendance-system-web:latest .

# Restart web deployment
kubectl rollout restart deployment/web
```

## Database Credentials

- **Host**: db (service name)
- **Database**: attendance_system
- **User**: annisa
- **Password**: 12345
- **Root Password**: root

## File Structure

```
.
├── db.yaml                    # Database deployment
├── web-deployment.yaml         # Web application deployment
├── phpmyadmin-deployment.yaml  # PHPMyAdmin deployment
├── Dockerfile                  # Docker image build file
├── k8s-setup.ps1              # Automated setup script
└── php-login-register/        # Application source code
```

