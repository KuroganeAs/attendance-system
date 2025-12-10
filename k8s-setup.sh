#!/bin/bash

echo "=== Kubernetes Setup for Attendance System ==="
echo ""

# Build Docker image
echo "1. Building Docker image..."
docker build -t attendance-system-web:latest .

# Load image into Kubernetes cluster
echo ""
echo "2. Loading Docker image into Kubernetes cluster..."
docker save attendance-system-web:latest | kubectl load -i -

# Apply database configuration
echo ""
echo "3. Deploying database..."
kubectl apply -f db.yaml

# Wait for database to be ready
echo ""
echo "4. Waiting for database to be ready..."
kubectl wait --for=condition=ready pod -l app=mysql --timeout=120s

# Deploy web application
echo ""
echo "5. Deploying web application..."
kubectl apply -f web-deployment.yaml

# Deploy PHPMyAdmin
echo ""
echo "6. Deploying PHPMyAdmin..."
kubectl apply -f phpmyadmin-deployment.yaml

# Get service information
echo ""
echo "7. Getting service information..."
echo ""
echo "=== Deployment Status ==="
kubectl get deployments
echo ""
echo "=== Service Information ==="
kubectl get services
echo ""
echo "=== Pod Status ==="
kubectl get pods

echo ""
echo "=== Access Information ==="
echo "To access services, use port forwarding:"
echo ""
echo "Web Application:"
echo "  kubectl port-forward service/web 8085:80"
echo "  Then open: http://localhost:8085"
echo ""
echo "PHPMyAdmin:"
echo "  kubectl port-forward service/phpmyadmin 8086:80"
echo "  Then open: http://localhost:8086"
echo ""
echo "Or get NodePort (if using NodePort):"
kubectl get svc web phpmyadmin

