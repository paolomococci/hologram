# Minimum CMake version required
cmake_minimum_required(VERSION 3.16)

# Project name and language
project(Tasks LANGUAGES CXX)

# ------------------------------------------------------------------
# C++ standard configuration
# ------------------------------------------------------------------
set(CMAKE_CXX_STANDARD 17)                 # Use C++17
set(CMAKE_CXX_STANDARD_REQUIRED ON)        # Enforce the standard

# ------------------------------------------------------------------
# Qt 6 configuration
# ------------------------------------------------------------------
find_package(Qt6 REQUIRED COMPONENTS Quick QuickControls2)

# Enable the automatic moc, uic, and rcc modules
set(CMAKE_AUTOMOC ON)
set(CMAKE_AUTOUIC ON)
set(CMAKE_AUTORCC ON)

# ------------------------------------------------------------------
# Source files
# ------------------------------------------------------------------
set(SRC_DIR ${CMAKE_CURRENT_SOURCE_DIR}/src)

# Add the executable target.  All listed files are compiled into it.
add_executable(${PROJECT_NAME}
    ${SRC_DIR}/main.cpp
    ${SRC_DIR}/Task.cpp
    ${SRC_DIR}/TaskModel.cpp
    ${SRC_DIR}/TaskProvider.cpp
    ${SRC_DIR}/Functions.cpp
    ${CMAKE_CURRENT_SOURCE_DIR}/resources.qrc          # Resource file
)

# ------------------------------------------------------------------
# Include directories and library linking
# ------------------------------------------------------------------
target_include_directories(${PROJECT_NAME} PRIVATE ${SRC_DIR})           # Include header files
target_link_libraries(${PROJECT_NAME} PRIVATE Qt6::Quick Qt6::QuickControls2)