# security-139
This is the vulnerable version of the easy mode of the project for the computer security course.

## How to run
To run this project clone the repository and navigate to the directory. For a first time set up run:
```bash
docker-compose up --build
```

To resume after stopping run:
```bash
docker-compose up
```

To rebuild everything from scratch run:
```bash
docker-compose down -v
docker-compose up --build
```