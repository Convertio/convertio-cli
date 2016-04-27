Command Line Interface for Convertio
=======================

This CLI Utility for [Convertio](https://convertio.co/cli/) allows easy and fast conversions of files using the terminal.

Feel free to use, improve or modify this open source software! If you have questions contact us or open an issue on GitHub.

Requirements
-------------------
* [PHP 5.3.0 or higher with CURL Support](http://www.php.net/)

Developer Documentation
-------------------
You can find full CLI installation and usage reference here: https://convertio.co/cli/

Installation
-------------------
The preferred mode is to install precompiled binary by executing these tiny commands:
```
  $ sudo wget --no-check-certificate -O '/usr/local/bin/convertio' https://api.convertio.co/convertio
  $ sudo chmod +x /usr/local/bin/convertio
```

If you want to compile from source, then make sure you have set `phar.readonly = Off` in your php.ini, then clone this repository and execute `compile.php` as follows:
```
  $ git clone --recursive https://github.com/convertio/convertio-cli.git
  $ cd convertio-cli
  $ php compile.php
  $ sudo mv release/convertio /usr/local/bin/convertio
```

Usage
-------------------
To use the CLI you have to [obtain an API Key](https://convertio.co/api/)

Set your Convertio API Key as environment variable:
```
  $ export CONVERTIO_API_KEY=_YOUR_API_KEY_
```

Following command will convert input.pdf into JPG:
```
  $ convertio -f jpg input.pdf
  /home/input.pdf: Done! => /home/input.jpg [379699 Bytes]

  All Done!
```

Batch converting also supported:
```
  $ convertio -f pdf *.txt
  1.txt: Done! => ./1.pdf [32999 Bytes]
  2.txt: Done! => ./2.pdf [32999 Bytes]

  All Done!
```

CLI Command Options
-------------------
```
$ convertio --help

Convertio CLI Utility [Info: https://convertio.co/api/]

Usage: convertio [options] [files...]

Options:

  -h, --help                    output usage information
  -f, --format <format>         set the output format the file(s) should be converted to
  -o, --outputdir <directory>   set the directory for storing the output files. defaults to the working directory
  --apikey <value>              set the API key. Alternatively you can use the CONVERTIO_API_KEY environment variable
  -V, --version                 output the version number

Examples:
  $ export CONVERTIO_API_KEY=_YOUR_API_KEY_
  $ convertio -f pdf *.txt
```

Resources
---------

* [Convertio API Page](https://convertio.co/api/)
* [Convertio CLI Reference](https://convertio.co/cli/)
* [Conversion Types](https://convertio.co/formats)