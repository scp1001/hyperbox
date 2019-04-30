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
wallet = Int('wallet')
cell1 = Int('cell1')
cell2 = Int('cell2')
cell3 = Int('cell3')
cell4 = Int('cell4')
cell5 = Int('cell5')
cell6 = Int('cell6')
cell7 = Int('cell7')
cell8 = Int('cell8')
cell9 = Int('cell9')
height = Int('height')
deadline1 = Int('deadline1')
s = Solver()


s.add(Or(cell1 == 0, cell1 == 1, cell1 == 10))
s.add(Or(cell2 == 0, cell2 == 1, cell2 == 10))
s.add(Or(cell3 == 0, cell3 == 1, cell3 == 10))
s.add(Or(cell4 == 0, cell4 == 1, cell4 == 10))
s.add(Or(cell5 == 0, cell5 == 1, cell5 == 10))
s.add(Or(cell6 == 0, cell6 == 1, cell6 == 10))
s.add(Or(cell7 == 0, cell7 == 1, cell7 == 10))
s.add(Or(cell8 == 0, cell8 == 1, cell8 == 10))
s.add(Or(cell9 == 0, cell9 == 1, cell9 == 10))

#s.add(wallet != 1000, wallet != 500)

s.add(wallet == 300)

#s.add(cell1 == 1, cell2 == 1, cell3 == 1)






s.add(Or(     And(wallet == 100, Or( cell1 + cell2 + cell3 == 3 , cell4 + cell5 + cell6 == 3 , cell7 + cell8 + cell9 == 3 , cell1 + cell4 + cell7 == 3 , cell2 + cell5 + cell8 == 3 , cell3 + cell6 + cell9 == 3 , cell1 + cell5 + cell9 == 3 , cell3 + cell5 + cell7 == 3 )),  And(wallet == 500, Or( cell1 + cell2 + cell3 == 30 , cell4 + cell5 + cell6 == 30 , cell7 + cell8 + cell9 == 30 , cell1 + cell4 + cell7 == 30 , cell2 + cell5 + cell8 == 30 , cell3 + cell6 + cell9 == 30 , cell1 + cell5 + cell9 == 30 , cell3 + cell5 + cell7 == 30 ))))

#s.add(Not(Or(     And(wallet == 100, Or( cell1 + cell2 + cell3 == 3 , cell4 + cell5 + cell6 == 3 , cell7 + cell8 + cell9 == 3 , cell1 + cell4 + cell7 == 3 , cell2 + cell5 + cell8 == 3 , cell3 + cell6 + cell9 == 3 , cell1 + cell5 + cell9 == 3 , cell3 + cell5 + cell7 == 3 )),  And(wallet == 500, Or( cell1 + cell2 + cell3 == 30 , cell4 + cell5 + cell6 == 30 , cell7 + cell8 + cell9 == 30 , cell1 + cell4 + cell7 == 30 , cell2 + cell5 + cell8 == 30 , cell3 + cell6 + cell9 == 30 , cell1 + cell5 + cell9 == 30 , cell3 + cell5 + cell7 == 30 )))))


ind = 0

f = open("/root/all/bin/python/log.txt", "w+")

while s.check() == sat:
  ind = ind +1
  print "Next:"
  print ind
  m = s.model()
  print m
  f.write(str(m))
  f.write("\n\n")
  s.add(Or(wallet != s.model()[wallet],cell1 != s.model()[cell1], cell2 != s.model()[cell2], cell3 != s.model()[cell3], cell4 != s.model()[cell4], cell5 != s.model()[cell5], cell6 != s.model()[cell6], cell7 != s.model()[cell7], cell8 != s.model()[cell8], cell9 != s.model()[cell9])) # prevent next model from using the same assignment as a previous model



print "Total solution number: "
print ind  

f.close()
  
#print(s.check())

#print(s.model())



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
wallet = Int('wallet')
cell1 = Int('cell1')
cell2 = Int('cell2')
cell3 = Int('cell3')
cell4 = Int('cell4')
cell5 = Int('cell5')
cell6 = Int('cell6')
cell7 = Int('cell7')
cell8 = Int('cell8')
cell9 = Int('cell9')
height = Int('height')
deadline1 = Int('deadline1')
s = Solver()


s.add(Or(cell1 == 0, cell1 == 1, cell1 == 10))
s.add(Or(cell2 == 0, cell2 == 1, cell2 == 10))
s.add(Or(cell3 == 0, cell3 == 1, cell3 == 10))
s.add(Or(cell4 == 0, cell4 == 1, cell4 == 10))
s.add(Or(cell5 == 0, cell5 == 1, cell5 == 10))
s.add(Or(cell6 == 0, cell6 == 1, cell6 == 10))
s.add(Or(cell7 == 0, cell7 == 1, cell7 == 10))
s.add(Or(cell8 == 0, cell8 == 1, cell8 == 10))
s.add(Or(cell9 == 0, cell9 == 1, cell9 == 10))

#s.add(wallet != 1000, wallet != 500)

s.add(wallet == 100)

s.add(cell1 == 1, cell2 == 1, cell3 == 1)






s.add(Or(     And(wallet == 100, Or( cell1 + cell2 + cell3 == 3 , cell4 + cell5 + cell6 == 3 , cell7 + cell8 + cell9 == 3 , cell1 + cell4 + cell7 == 3 , cell2 + cell5 + cell8 == 3 , cell3 + cell6 + cell9 == 3 , cell1 + cell5 + cell9 == 3 , cell3 + cell5 + cell7 == 3 )),  And(wallet == 500, Or( cell1 + cell2 + cell3 == 30 , cell4 + cell5 + cell6 == 30 , cell7 + cell8 + cell9 == 30 , cell1 + cell4 + cell7 == 30 , cell2 + cell5 + cell8 == 30 , cell3 + cell6 + cell9 == 30 , cell1 + cell5 + cell9 == 30 , cell3 + cell5 + cell7 == 30 ))))

#s.add(Not(Or(     And(wallet == 100, Or( cell1 + cell2 + cell3 == 3 , cell4 + cell5 + cell6 == 3 , cell7 + cell8 + cell9 == 3 , cell1 + cell4 + cell7 == 3 , cell2 + cell5 + cell8 == 3 , cell3 + cell6 + cell9 == 3 , cell1 + cell5 + cell9 == 3 , cell3 + cell5 + cell7 == 3 )),  And(wallet == 500, Or( cell1 + cell2 + cell3 == 30 , cell4 + cell5 + cell6 == 30 , cell7 + cell8 + cell9 == 30 , cell1 + cell4 + cell7 == 30 , cell2 + cell5 + cell8 == 30 , cell3 + cell6 + cell9 == 30 , cell1 + cell5 + cell9 == 30 , cell3 + cell5 + cell7 == 30 )))))


ind = 0

f = open("/root/all/bin/python/log.txt", "w+")

while s.check() == sat:
  ind = ind +1
  print "Next:"
  print ind
  m = s.model()
  print m
  f.write(str(m))
  f.write("\n\n")
  s.add(Or(wallet != s.model()[wallet],cell1 != s.model()[cell1], cell2 != s.model()[cell2], cell3 != s.model()[cell3], cell4 != s.model()[cell4], cell5 != s.model()[cell5], cell6 != s.model()[cell6], cell7 != s.model()[cell7], cell8 != s.model()[cell8], cell9 != s.model()[cell9])) # prevent next model from using the same assignment as a previous model



print "Total solution number: "
print ind  

f.close()
  
#print(s.check())

#print(s.model())


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
size = Int('size')
cell1 = Int('cell1')
cell2 = Int('cell2')
cell3 = Int('cell3')
cell4 = Int('cell4')
cell5 = Int('cell5')
cell6 = Int('cell6')
cell7 = Int('cell7')
cell8 = Int('cell8')
cell9 = Int('cell9')

s = Solver()


s.add(Or(cell1 == 0, cell1 == 1, cell1 == 10))
s.add(Or(cell2 == 0, cell2 == 1, cell2 == 10))
s.add(Or(cell3 == 0, cell3 == 1, cell3 == 10))
s.add(Or(cell4 == 0, cell4 == 1, cell4 == 10))
s.add(Or(cell5 == 0, cell5 == 1, cell5 == 10))
s.add(Or(cell6 == 0, cell6 == 1, cell6 == 10))
s.add(Or(cell7 == 0, cell7 == 1, cell7 == 10))
s.add(Or(cell8 == 0, cell8 == 1, cell8 == 10))
s.add(Or(cell9 == 0, cell9 == 1, cell9 == 10))

s.add(cell1 == 0, cell2 == 10, cell3 == 10, cell4 == 0, cell5 == 1, cell6 == 0, cell7 == 0, cell8 == 10, cell9 == 1)




ind = 0

f = open("/root/all/bin/python/log2.txt", "w+")

while s.check() == sat:
  ind = ind +1
  print "Next:"
  print ind
  m = s.model()
  print m
  f.write(str(m))
  f.write("\n\n")
  s.add(Or(cell1 != s.model()[cell1], cell2 != s.model()[cell2], cell3 != s.model()[cell3], cell4 != s.model()[cell4], cell5 != s.model()[cell5], cell6 != s.model()[cell6], cell7 != s.model()[cell7], cell8 != s.model()[cell8], cell9 != s.model()[cell9])) # prevent next model from using the same assignment as a previous model



print "Total solution number: "
print ind  

f.close()
  
#print(s.check())

#print(s.model())

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
wallet = Int('wallet')
cell1 = Int('cell1')
cell2 = Int('cell2')
cell3 = Int('cell3')
cell4 = Int('cell4')
cell5 = Int('cell5')
cell6 = Int('cell6')
cell7 = Int('cell7')
cell8 = Int('cell8')
cell9 = Int('cell9')
height = Int('height')
deadline1 = Int('deadline1')
s = Solver()


s.add(Or(cell1 == 0, cell1 == 1, cell1 == 10))
s.add(Or(cell2 == 0, cell2 == 1, cell2 == 10))
s.add(Or(cell3 == 0, cell3 == 1, cell3 == 10))
s.add(Or(cell4 == 0, cell4 == 1, cell4 == 10))
s.add(Or(cell5 == 0, cell5 == 1, cell5 == 10))
s.add(Or(cell6 == 0, cell6 == 1, cell6 == 10))
s.add(Or(cell7 == 0, cell7 == 1, cell7 == 10))
s.add(Or(cell8 == 0, cell8 == 1, cell8 == 10))
s.add(Or(cell9 == 0, cell9 == 1, cell9 == 10))

#s.add(wallet != 1000, wallet != 500)

s.add(wallet == 300)

#(cell1 == 1, cell2 == 1, cell3 == 1), (cell4 == 1, cell5 == 1, cell6 == 1), (cell7 == 1, cell8 == 1, cell9 == 1)

#s.add( Or(   And(cell1 == 1, cell2 == 1, cell3 == 1), And(cell4 == 1, cell5 == 1, cell6 == 1), And(cell7 == 1, cell8 == 1, cell9 == 1),
#	And(cell1 == 1, cell4 == 1, cell7 == 1), And(cell2 == 1, cell5 == 1, cell8 == 1), And(cell3 == 7, cell6 == 8, cell9 == 9),
#	And(cell1 == 1, cell5 == 1, cell9 == 1), And(cell3 == 1, cell5 == 1, cell7 == 1)) ) 



s.add(Or(     And(wallet == 100, Or( cell1 + cell2 + cell3 == 3 , cell4 + cell5 + cell6 == 3 , cell7 + cell8 + cell9 == 3 , cell1 + cell4 + cell7 == 3 , cell2 + cell5 + cell8 == 3 , cell3 + cell6 + cell9 == 3 , cell1 + cell5 + cell9 == 3 , cell3 + cell5 + cell7 == 3 )),  And(wallet == 500, Or( cell1 + cell2 + cell3 == 30 , cell4 + cell5 + cell6 == 30 , cell7 + cell8 + cell9 == 30 , cell1 + cell4 + cell7 == 30 , cell2 + cell5 + cell8 == 30 , cell3 + cell6 + cell9 == 30 , cell1 + cell5 + cell9 == 30 , cell3 + cell5 + cell7 == 30 ))))

#s.add(Not(Or(     And(wallet == 100, Or( cell1 + cell2 + cell3 == 3 , cell4 + cell5 + cell6 == 3 , cell7 + cell8 + cell9 == 3 , cell1 + cell4 + cell7 == 3 , cell2 + cell5 + cell8 == 3 , cell3 + cell6 + cell9 == 3 , cell1 + cell5 + cell9 == 3 , cell3 + cell5 + cell7 == 3 )),  And(wallet == 500, Or( cell1 + cell2 + cell3 == 30 , cell4 + cell5 + cell6 == 30 , cell7 + cell8 + cell9 == 30 , cell1 + cell4 + cell7 == 30 , cell2 + cell5 + cell8 == 30 , cell3 + cell6 + cell9 == 30 , cell1 + cell5 + cell9 == 30 , cell3 + cell5 + cell7 == 30 )))))


ind = 0

f = open("/root/all/bin/python/log3.txt", "w+")

while s.check() == sat:
  ind = ind +1
  print "Next:"
  print ind
  m = s.model()
  print m
  f.write(str(m))
  f.write("\n\n")
  s.add(Or(wallet != s.model()[wallet],cell1 != s.model()[cell1], cell2 != s.model()[cell2], cell3 != s.model()[cell3], cell4 != s.model()[cell4], cell5 != s.model()[cell5], cell6 != s.model()[cell6], cell7 != s.model()[cell7], cell8 != s.model()[cell8], cell9 != s.model()[cell9])) # prevent next model from using the same assignment as a previous model



print "Total solution number: "
print ind  

f.close()
  
#print(s.check())

#print(s.model())



