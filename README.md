# Ping Checker using Check-Host API

This is a simple PHP script that checks the ping time to a specified host using the Check-Host API. The script fetches the ping data from 3 different nodes (Tehran, Shiraz, and Tabriz) and calculates their average values, converts them to milliseconds and returns the results as a JSON object.

## Usage

To use this script, simply call the PHP file with the host parameter set to the desired host. For example:

https://example.com/index.php?host=google.com


## API endpoint

The script uses the following endpoint to retrieve ping data:

https://check-host.net/check-ping


## Dependencies

This script requires the cURL library to be installed on the server.

## License

This script is licensed under the MIT License. Feel free to use, modify, and distribute it as you wish.
