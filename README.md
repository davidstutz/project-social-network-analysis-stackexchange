# README

This is part of a project done for the ["Social Network Analysis" MOOC](https://www.coursera.org/course/sna) offered by the University of Michigan and instructed by [Lada Adamic](http://www.ladamic.com/).

I analyzed the publicly available data dumps from StackExchange. The latest data dumps are available [here](https://archive.org/details/stackexchange) and some older data dumps are available [here](http://meta.stackexchange.com/questions/198915/is-there-a-direct-download-link-with-a-raw-data-dump-of-stack-overflow-not-a-t).

## Graphs

The raw `.xml` files (for `crypto.stackexchange.com` and `datascience.stackexchange.com` these are provided in `data/`) have been converted to `.gml` files using the PHP scripts in `lib/`, the graphs can be read using [Gephi](https://gephi.org/).

Alternatively, the graphs can be read using Python's igraph package, see `info.py`.

Graphs for the following (small) StackExchange sites are provided:

* `graphs/biology.stackexchange.com.gml`
* `graphs/blender.stackexchange.com.gml`
* `graphs/boardgames.stackexchange.com.gml`
* `graphs/crypto.stackexchange.com.gml`
* `graphs/datascience.stackexchange.com.gml`
* `graphs/fitness.stackexchange.com.gml`
* `graphs/freelancing.stackexchange.com.gml`
* `graphs/german.stackexchange.com.gml`
* `graphs/history.stackexchange.com.gml`
* `graphs/japanese.stackexchange.com.gml`
* `graphs/joomla.stackexchange.com.gml`
* `graphs/linguistics.stackexchange.com.gml`
* `graphs/matheducators.stackexchange.com.gml`
* `graphs/networkengineering.stackexchange.com.gml`
* `graphs/opendata.stackexchange.com.gml`
* `graphs/parenting.stackexchange.com.gml`
* `graphs/philosophy.stackexchange.com.gml`
* `graphs/poker.stackexchange.com.gml`
* `graphs/politics.stackexchange.com.gml`
* `graphs/productivity.stackexchange.com.gml`
* `graphs/reverseengineering.stackexchange.com.gml`
* `graphs/robotics.stackexchange.com.gml`

## Report

A superficial and short report can be found in `report.pdf`.

## License

Data is licensed as indicated here: [https://archive.org/details/stackexchange](https://archive.org/details/stackexchange)

Code is published under the BSD 3-Clause license:

Copyright (c) 2014 - 2016, David Stutz All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
* Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

The report is licensed under the Creative Commons Attribution 4.0 International License. To view a copy of this license, visit [http://creativecommons.org/licenses/by/4.0/](http://creativecommons.org/licenses/by/4.0/).
