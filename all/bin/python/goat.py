# Copyright (c) Microsoft Corporation 2015, 2016

# The Z3 Python API requires libz3.dll/.so/.dylib in the 
# PATH/LD_LIBRARY_PATH/DYLD_LIBRARY_PATH
# environment variable and the PYTHONPATH environment variable
# needs to point to the `python' directory that contains `z3/z3.py'
# (which is at bin/python in our binary releases).

# If you obtained example.py as part of our binary release zip files,
# which you unzipped into a directory called `MYZ3', then follow these
# instructions to run the example:

# Running this example on Windows:
# set PATH=%PATH%;MYZ3\bin
# set PYTHONPATH=MYZ3\bin\python
# python example.py

# Running this example on Linux:
# export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:MYZ3/bin
# export PYTHONPATH=MYZ3/bin/python
# python example.py

# Running this example on macOS:
# export DYLD_LIBRARY_PATH=$DYLD_LIBRARY_PATH:MYZ3/bin
# export PYTHONPATH=MYZ3/bin/python
# python example.py

Num= 8

import json

from z3 import *

s = Solver()

#Defining 10 states
Human = [ Int('Human_%i' % (i + 1)) for i in range(Num) ]
Woolf = [ Int('Woolf_%i' % (i + 1)) for i in range(Num) ]
Goat = [ Int('Goat_%i' % (i + 1)) for i in range(Num) ]
Cabbage = [ Int('Cabbage_%i' % (i + 1)) for i in range(Num) ]






# Each creature can be only on left (0) or right side (1) on every state
HumanSide = [ Or(Human[i] == 0, Human[i] == 1) for i in range(Num) ]
WoolfSide = [ Or(Woolf[i] == 0, Woolf[i] == 1) for i in range(Num) ]
GoatSide = [ Or(Goat[i] == 0, Goat[i] == 1) for i in range(Num) ]
CabbageSide = [ Or(Cabbage[i] == 0, Cabbage[i] == 1) for i in range(Num) ]
Side = HumanSide+WoolfSide+GoatSide+CabbageSide


Start = [ Human[0] == 0, Woolf[0] == 0, Goat[0] == 0, Cabbage[0] == 0 ]
Finish = [ Human[7] == 1, Woolf[7] == 1, Goat[7] == 1, Cabbage[7] == 1 ]




# Woolf cant stand with goat, and goat with cabbage without human. Not 2, not 0 which means that they are one the same side
Safe = [ And( Or(Woolf[i] != Goat[i], Woolf[i] == Human[i]), Or(Goat[i] != Cabbage[i], Goat[i] == Human[i])) for i in range(Num) ]

# Human can not travel, travel alone, or he can take somebody
# In last case he can travel or not travel alone
Travel = [ Or(
And(Human[i] == Human[i+1] + 1, Woolf[i] == Woolf[i+1] + 1, Goat[i] == Goat[i+1], Cabbage[i] == Cabbage[i+1]),
And(Human[i] == Human[i+1] + 1, Goat[i] == Goat[i+1] + 1, Woolf[i] == Woolf[i+1], Cabbage[i] == Cabbage[i+1]),
And(Human[i] == Human[i+1] + 1, Cabbage[i] == Cabbage[i+1] + 1, Woolf[i] == Woolf[i+1], Goat[i] == Goat[i+1]),
And(Human[i] == Human[i+1] - 1, Woolf[i] == Woolf[i+1] - 1, Goat[i] == Goat[i+1], Cabbage[i] == Cabbage[i+1]),
And(Human[i] == Human[i+1] - 1, Goat[i] == Goat[i+1] - 1, Woolf[i] == Woolf[i+1], Cabbage[i] == Cabbage[i+1]),
And(Human[i] == Human[i+1] - 1, Cabbage[i] == Cabbage[i+1] - 1, Woolf[i] == Woolf[i+1], Goat[i] == Goat[i+1]),
And(Woolf[i] == Woolf[i+1], Goat[i] == Goat[i+1], Cabbage[i] == Cabbage[i+1])) for i in range(Num-1) ]














solve(Side + Start + Finish + Safe + Travel)