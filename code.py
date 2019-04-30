

import json

from z3 import *

s = Solver()

  
  
    
Steps=1
Num= Steps+1

human = [ Int('human_%i' % (i + 1)) for i in range(Num) ]
wolf = [ Int('wolf_%i' % (i + 1)) for i in range(Num) ]
goat = [ Int('goat_%i' % (i + 1)) for i in range(Num) ]
cabbage = [ Int('cabbage_%i' % (i + 1)) for i in range(Num) ]
nothing= [  And( human[i] == human[i+1], wolf[i] == wolf[i+1], goat[i] == goat[i+1], cabbage[i] == cabbage[i+1] )   for i in range(Num-1) ]


start= [ human[0] == 0, wolf[0] == 0, goat[0] == 0, cabbage[0] == 0 ]

safeAlone= [  And( goat[i+1] != wolf[i+1] , goat[i+1] != cabbage[i+1] )   for i in range(Num-1) ]
safe= [  Or( safeAlone[i] , goat[i+1]  ==  human[i+1] )   for i in range(Num-1) ]
humanTravel= [  human[i] != human[i+1]  for i in range(Num-1) ]
cabbageSide= [  Or( cabbage[i]  ==  0 , cabbage[i]  ==  1 )   for i in range(Num-1) ]
goatSide= [  Or( goat[i]  ==  0 , goat[i]  ==  1 )   for i in range(Num-1) ]
humanSide= [  Or( human[i]  ==  0 , human[i]  ==  1 )   for i in range(Num-1) ]
t7= [  And( And( And( humanTravel[i] , wolf[i+1]  ==  wolf[i] )  , goat[i+1]  ==  goat[i] )  , cabbage[i+1]  ==  cabbage[i] )   for i in range(Num-1) ]
t3= [  And( And( And( humanTravel[i] , wolf[i+1]  ==  wolf[i] )  , goat[i+1]  ==  goat[i] )  , cabbage[i+1]  ==  cabbage[i] + 1 )   for i in range(Num-1) ]
t6= [  And( And( And( humanTravel[i] , wolf[i+1]  ==  wolf[i] )  , goat[i+1]  ==  goat[i] )  , cabbage[i+1]  ==  cabbage[i] - 1 )   for i in range(Num-1) ]
t2= [  And( And( And( humanTravel[i] , wolf[i+1]  ==  wolf[i] )  , goat[i+1]  ==  goat[i] + 1 )  , cabbage[i+1]  ==  cabbage[i] )   for i in range(Num-1) ]
t5= [  And( And( And( humanTravel[i] , wolf[i+1]  ==  wolf[i] )  , goat[i+1]  ==  goat[i] - 1 )  , cabbage[i+1]  ==  cabbage[i] )   for i in range(Num-1) ]
t1= [  And( And( And( humanTravel[i] , wolf[i+1]  ==  wolf[i] + 1 )  , goat[i+1]  ==  goat[i] )  , cabbage[i+1]  ==  cabbage[i] )   for i in range(Num-1) ]
t4= [  And( And( And( humanTravel[i] , wolf[i+1]  ==  wolf[i] - 1 )  , goat[i+1]  ==  goat[i] )  , cabbage[i+1]  ==  cabbage[i] )   for i in range(Num-1) ]
wolfSide= [  Or( wolf[i]  ==  0 , wolf[i]  ==  1 )   for i in range(Num-1) ]
side= [  And( And( And( humanSide[i] , wolfSide[i] )  , goatSide[i] )  , cabbageSide[i] )   for i in range(Num-1) ]
objectTravel= [  Or( Or( Or( Or( Or( Or( t1[i] , t2[i] )  , t3[i] )  , t4[i] )  , t5[i] )  , t6[i] )  , t7[i] )   for i in range(Num-1) ]
data= [ Or(  And( And( And( side[i] , safe[i] )  , humanTravel[i] )  , objectTravel[i] )   , nothing[i]) for i in range(Num-1) ]


final= [ human[1] == 1, wolf[1] == 0, goat[1] == 1, cabbage[1] == 0 ]



#template, only start rest
s.add(data + start)

#template
s.add(final)




ind = 0

f = open("/var/www/html/all/bin/python/log.txt", "a")



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
 

