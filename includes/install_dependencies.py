import subprocess
import sys

def install_build_dependencies(packages):
    try:
        for package in packages:
            subprocess.check_call([sys.executable, '-m', 'pip', 'install', package])
        print("Build dependencies installed successfully.")
    except subprocess.CalledProcessError as e:
        print(f"Error installing build dependencies: {e}")
if __name__ == "__main__":
    build_dependencies = ["dependency1", "dependency2", "dependency3"]
    install_build_dependencies(build_dependencies)
