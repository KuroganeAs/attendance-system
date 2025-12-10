# Kubernetes Setup Script for Windows PowerShell
Write-Host "=== Kubernetes Setup for Attendance System ===" -ForegroundColor Cyan
Write-Host ""

# Build Docker image
Write-Host "1. Building Docker image..." -ForegroundColor Yellow
docker build -t attendance-system-web:latest .

if ($LASTEXITCODE -ne 0) {
    Write-Host "Error building Docker image!" -ForegroundColor Red
    exit 1
}

# Load image into Kubernetes cluster (Docker Desktop)
Write-Host ""
Write-Host "2. Loading Docker image into Kubernetes cluster..." -ForegroundColor Yellow
# For Docker Desktop, images are automatically available
# But we can verify it exists
docker images | Select-String "attendance-system-web"

# Apply database configuration
Write-Host ""
Write-Host "3. Deploying database..." -ForegroundColor Yellow
kubectl apply -f db.yaml

# Wait for database to be ready
Write-Host ""
Write-Host "4. Waiting for database to be ready..." -ForegroundColor Yellow
Start-Sleep -Seconds 5
kubectl wait --for=condition=ready pod -l app=mysql --timeout=120s

# Deploy web application
Write-Host ""
Write-Host "5. Deploying web application..." -ForegroundColor Yellow
kubectl apply -f web-deployment.yaml

# Deploy PHPMyAdmin
Write-Host ""
Write-Host "6. Deploying PHPMyAdmin..." -ForegroundColor Yellow
kubectl apply -f phpmyadmin-deployment.yaml

# Get service information
Write-Host ""
Write-Host "7. Getting service information..." -ForegroundColor Yellow
Write-Host ""
Write-Host "=== Deployment Status ===" -ForegroundColor Green
kubectl get deployments

Write-Host ""
Write-Host "=== Service Information ===" -ForegroundColor Green
kubectl get services

Write-Host ""
Write-Host "=== Pod Status ===" -ForegroundColor Green
kubectl get pods

Write-Host ""
Write-Host "=== Access Information ===" -ForegroundColor Cyan
Write-Host "To access services, use port forwarding:" -ForegroundColor White
Write-Host ""
Write-Host "Web Application:" -ForegroundColor Yellow
Write-Host "  kubectl port-forward service/web 8085:80" -ForegroundColor White
Write-Host "  Then open: http://localhost:8085" -ForegroundColor White
Write-Host ""
Write-Host "PHPMyAdmin:" -ForegroundColor Yellow
Write-Host "  kubectl port-forward service/phpmyadmin 8086:80" -ForegroundColor White
Write-Host "  Then open: http://localhost:8086" -ForegroundColor White
Write-Host ""
Write-Host "To get NodePort (if using NodePort):" -ForegroundColor Yellow
kubectl get svc web phpmyadmin

