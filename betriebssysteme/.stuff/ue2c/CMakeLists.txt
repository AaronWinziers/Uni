cmake_minimum_required(VERSION 3.15)
project(ue2c C)

set(CMAKE_C_STANDARD 99)

add_executable(ue2c main.c)

target_link_libraries(ue2c m)