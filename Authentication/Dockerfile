FROM openjdk
RUN mkdir /auth
COPY Signup-Signin/build/libs/Signup-Signin-0.0.1-SNAPSHOT.jar /auth/
CMD ["java", "-jar", "/auth/Signup-Signin-0.0.1-SNAPSHOT.jar"]
EXPOSE 8080
