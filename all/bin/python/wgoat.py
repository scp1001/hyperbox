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



import json

from z3 import *

s = Solver()

  
  
    
Steps=7
Num= Steps+1

human = [ Int('human_%i' % (i + 1)) for i in range(Num) ]
wolf = [ Int('wolf_%i' % (i + 1)) for i in range(Num) ]
goat = [ Int('goat_%i' % (i + 1)) for i in range(Num) ]
cabbage = [ Int('cabbage_%i' % (i + 1)) for i in range(Num) ]

start= [ human[0] == 0, wolf[0] == 0, goat[0] == 0, cabbage[0] == 0 ]




humanTravel= [ human[i] != human[i+1] for i in range(Num-1) ]
cabbageSide= [ Or( cabbage[i] == 0 , cabbage[i] == 1 ) for i in range(Num-1) ]
goatSide= [ Or( goat[i] == 0 , goat[i] == 1 ) for i in range(Num-1) ]
humanSide= [ Or( human[i] == 0 , human[i] == 1 ) for i in range(Num-1) ]
t7= [ And( And( And( humanTravel[i] , wolf[i+1] == wolf[i] ) , goat[i+1] == goat[i] ) , cabbage[i+1] == cabbage[i] ) for i in range(Num-1) ]
t4= [ And( And( And( humanTravel[i] , wolf[i+1] == wolf[i] ) , goat[i+1] == goat[i] ) , cabbage[i+1] == cabbage[i] + 1 ) for i in range(Num-1) ]
t1= [ And( And( And( humanTravel[i] , wolf[i+1] == wolf[i] ) , goat[i+1] == goat[i] ) , cabbage[i+1] == cabbage[i] - 1 ) for i in range(Num-1) ]
t3= [ And( And( And( humanTravel[i] , wolf[i+1] == wolf[i] ) , goat[i+1] == goat[i] + 1 ) , cabbage[i+1] == cabbage[i] ) for i in range(Num-1) ]
t6= [ And( And( And( humanTravel[i] , wolf[i+1] == wolf[i] ) , goat[i+1] == goat[i] - 1 ) , cabbage[i+1] == cabbage[i] ) for i in range(Num-1) ]
t2= [ And( And( And( humanTravel[i] , wolf[i+1] == wolf[i] + 1 ) , goat[i+1] == goat[i] ) , cabbage[i+1] == cabbage[i] ) for i in range(Num-1) ]
t5= [ And( And( And( humanTravel[i] , wolf[i+1] == wolf[i] - 1 ) , goat[i+1] == goat[i] ) , cabbage[i+1] == cabbage[i] ) for i in range(Num-1) ]
safeWithoutHuman= [ And( goat[i+1] != wolf[i+1] , goat[i+1] != cabbage[i+1] ) for i in range(Num-1) ]
wolfSide= [ Or( wolf[i] == 0 , wolf[i] == 1 ) for i in range(Num-1) ]
side= [ And( And( And( humanSide[i] , wolfSide[i] ) , goatSide[i] ) , cabbageSide[i] ) for i in range(Num-1) ]
safe= [ Or( safeWithoutHuman[i] , goat[i+1] == human[i+1] ) for i in range(Num-1) ]
objectTravel= [ Or( Or( Or( Or( Or( Or( t1[i] , t2[i] ) , t3[i] ) , t4[i] ) , t5[i] ) , t6[i] ) , t7[i] ) for i in range(Num-1) ]


#travel = [ Or(And(humanTravel[i], objectNotTravel), And(humanTravel[i], objectTravel[i]))   for i in range(Num-1) ]

#travel1 = [ Or(
#And(human[i] == human[i+1] + 1, wolf[i] == wolf[i+1] + 1, goat[i] == goat[i+1], cabbage[i] == cabbage[i+1]),
#And(human[i] == human[i+1] + 1, goat[i] == goat[i+1] + 1, wolf[i] == wolf[i+1], cabbage[i] == cabbage[i+1]),
#And(human[i] == human[i+1] + 1, cabbage[i] == cabbage[i+1] + 1, wolf[i] == wolf[i+1], goat[i] == goat[i+1]),
#And(human[i] == human[i+1] - 1, wolf[i] == wolf[i+1] - 1, goat[i] == goat[i+1], cabbage[i] == cabbage[i+1]),
#And(human[i] == human[i+1] - 1, goat[i] == goat[i+1] - 1, wolf[i] == wolf[i+1], cabbage[i] == cabbage[i+1]),
#And(human[i] == human[i+1] - 1, cabbage[i] == cabbage[i+1] - 1, wolf[i] == wolf[i+1], goat[i] == goat[i+1]),
#And(wolf[i] == wolf[i+1], goat[i] == goat[i+1], cabbage[i] == cabbage[i+1])) for i in range(Num-1) ]




data= [ And( And( And( side[i] , safe[i] ) , humanTravel[i] ) , objectTravel[i] ) for i in range(Num-1) ]

#template, only start rest
s.add(data + start)


second= And( goat[Steps] == 1 , cabbage[Steps] == 1 ) 
first= And( human[Steps] == 1 , wolf[Steps] == 1 ) 
final= And( first , second ) 

#template
s.add(final)




ind = 0

f = open("/root/all/bin/python/log.txt", "w+")



while s.check() == sat:
  ind = ind +1
  

  print ind
  m = s.model()
  print m

  print "traversing model..." 
  #for d in m.decls():
	#print "%s = %s" % (d.name(), m[d])

  
 
  f.write(str(m))
  f.write("\n\n")
  exit()
  #s.add(Or(goat[0] != s.model()[data[0]] )) # prevent next model from using the same assignment as a previous model



print "Total solution number: "
print ind  

f.close()
 

