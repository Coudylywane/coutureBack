pipeline {
    agent any
    
    stages {
        
        stage('Build') {
            steps {
                // Compile Java code
                sh 'javac HelloWorld.java'
            }
        }
        
        stage('Test') {
            steps {
                // Run unit tests (if applicable)
                echo 'Pas encore de test pour ce project'
            }
        }
        
        stage('Deploy') {
            steps {
                // Deployment steps (if applicable)
                echo 'Pas encore de deploiement pour ce project'
            }
        }
    }
}
