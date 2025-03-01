#!/bin/bash

# Set the script to exit on any error
set -e

# Display a message
echo "Starting CakePHP E2E Tests"
echo "=========================="

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
  echo "Error: Docker is not running. Please start Docker and try again."
  exit 1
fi

# Navigate to the project root
cd ../../..

# Ensure the application is running
echo "Ensuring the application is running..."
docker-compose down
docker-compose build
docker-compose up -d

# Wait for the application to start
echo "Waiting for the application to start..."
sleep 10

# Check if the application is accessible
echo "Checking if the application is accessible..."
if ! curl -s http://localhost:8080 > /dev/null; then
  echo "Error: The application is not accessible at http://localhost:8080"
  echo "Please check the Docker logs for more information:"
  echo "docker-compose logs"
  exit 1
fi

# Navigate back to the e2e test directory
cd app/tests/e2e

# Install dependencies if needed
if [ ! -d "node_modules" ]; then
  echo "Installing dependencies..."
  npm install
fi

# Install Playwright browsers if needed
if [ ! -d "node_modules/@playwright" ]; then
  echo "Installing Playwright browsers..."
  npx playwright install chromium
fi

# Run the tests
echo "Running E2E tests..."
npx playwright test

# Show the test report
echo "Tests completed. Opening test report..."
npx playwright show-report

echo "=========================="
echo "E2E Tests completed"
