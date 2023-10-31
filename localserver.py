
import subprocess
import json
from flask import Flask, request, Response

app = Flask(__name__)
app.config['COMPRESS_RESPONSE'] = True

LOCALHOST_ADD = ['127.0.0.1', 'localhost']


# main index 
@app.route('/cli/<cmd>', methods=['GET'])
def checkcmd(cmd):
    resultCommand = []
    resultCommand = run_command(cmd)
    if request.remote_addr in LOCALHOST_ADD:
        return resultCommand
    else:
        return "No Access!"
    
def run_command(command):
    # Execute the command using subprocess
    try:
        result = subprocess.check_output(command, shell=True, stderr=subprocess.STDOUT)
        return result
    except:
        return "Nothing to show!"

if __name__ == "__main__":
    app.run()
