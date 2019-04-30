
import json



from z3 import *
recipient = Int('recipient')
sender = Int('sender')
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
deadline = Int('deadline')
deadline1 = Int('deadline1')
all = Int('all')
diagonal1 = Int('diagonal1')
diagonal2 = Int('diagonal2')
column1 = Int('column1')
column2 = Int('column2')
column3 = Int('column3')
line1 = Int('line1')
line2 = Int('line2')
line3 = Int('line3')
zeroNum = Int('zeroNum')
crossNum = Int('crossNum')
zeroWin = Bool('zeroWin')
crossWin = Bool('crossWin')
timeout = Bool('timeout')
bobAddr = Int('bobAddr')
aliceAddr = Int('aliceAddr')
win = Bool('win')
draw = Bool('draw')
inputCorrect = Bool('inputCorrect')
gameFinished = Bool('gameFinished')
deadlineCorrect = Bool('deadlineCorrect')
inputSigned = Bool('inputSigned')
dataSize = Int('dataSize')
cellValue = Int('cellValue')
cell = Int('cell')
cellOk = Bool('cellOk')
dataOk = Bool('dataOk')
sumOk = Bool('sumOk')
#cellKey = Int('cellKey')
#deadlineKey = Int('deadlineKey')


adiagonal1 = Int('adiagonal1')
adiagonal2 = Int('adiagonal2')
aline1 = Int('aline1')
aline2 = Int('aline2')
aline3 = Int('aline3')
acolumn1 = Int('acolumn1')
acolumn2 = Int('acolumn2')
acolumn3 = Int('acolumn3')
aall = Int('aall')

azeroNum = Int('azeroNum')
acrossNum = Int('acrossNum')
azeroWin = Bool('azeroWin')
acrossWin = Bool('acrossWin')
agameFinished = Bool('agameFinished')



Num = 12
Input = [ Int('Input%i' % (i)) for i in xrange(0, Num + 1) ]
Input[0] = 0


InputKeys = [ Int('InputKeys%i' % (i)) for i in xrange(0, Num + 1) ]
InputKeys[0] = 0


acell = [ Int('acell%i' % (i)) for i in xrange(0, Num + 1) ]
acell[0] = 0



bcell = [ Int('acell%i' % (i)) for i in xrange(0, Num + 1) ]
bcell[0] = 0

s = Solver()













	
#Our own requirments

#wallet of recepient
s.add(Or(recipient == 100, recipient == 500))

#wallet of sender
s.add(Or(sender == 100, sender == 500))

#currentHeight
s.add(height == 1000)

s.add(deadline1 == 1005)

#s.add(Input[7] < 0)

#0 1 0
#0 0 1
#1 1 ?

acell[1] = 10
acell[2] = 1
acell[3] = 10
acell[4] = 10
acell[5] = 10
acell[6] = 1
acell[7] = 1
acell[8] = 1
acell[9] = 0
acell[10] = 1005
acell[11] = 0
acell[12] = 0

#s.add(cell1 == 0, cell2 == 1, cell3 == 0, cell4 == 1, cell5 == 0, cell6 == 1)
#-------


#Input architecture
def exists(x):
    return If(x >= -1000000,1,0)
sum= exists(Input[1]) + exists(Input[2]) + exists(Input[3]) + exists(Input[4]) + exists(Input[5]) + exists(Input[6]) + exists(Input[7]) + exists(Input[8]) + exists(Input[9]) + exists(Input[10]) + exists(Input[11]) + exists(Input[12])

sumOk = (And(dataSize == sum))



#Writing to contract operation, input data equall stored. Matching data required for win with Input data
#s.add(cell1 == Input[1], cell2 == Input[2], cell3 == Input[3], cell4 == Input[4], cell5 == Input[5], cell6 == Input[6],
#cell7 == Input[7], cell8 == Input[8], cell9 == Input[9], deadline1 == Input[10])



#Data conditions

#print InputKeys[1]
#exit()

cellKey = InputKeys[1] #Just first variable

#cell= Input[cellKey]   Just cant write this, need to include it into z3 logic
#So we adding correlation between cell and cellkey. We need to detect at there are 0 on field
cellOk= Or(And(cell == acell[1], cellKey == 1),And(cell == acell[2], cellKey == 2),And(cell == acell[3], cellKey == 3),And(cell == acell[4], cellKey == 4),And(cell == acell[5], cellKey == 5),
And(cell == acell[6], cellKey == 6),And(cell == acell[7], cellKey == 7),And(cell == acell[8], cellKey == 8),And(cell == acell[9], cellKey == 9),
And(cell == acell[10], cellKey == 10),And(cell == acell[11], cellKey == 11),And(cell == acell[12], cellKey == 12)) #,And(InputKeys[2] == 10)

deadlineKey = InputKeys[2] #Just second variable



inputCorrect = And(Or( cellKey== 1, cellKey== 2, cellKey== 3, cellKey== 4, cellKey== 5, cellKey== 6, cellKey== 7, cellKey== 8, cellKey== 9) , deadlineKey== 2 , dataSize== 2 , cell== 0, cellOk, InputKeys[1] == 1, InputKeys[2] == 10)

#Data variables
adiagonal1 = acell[1] + acell[5] + acell[9]
adiagonal2 = acell[3] + acell[5] + acell[7]
aline1 = acell[1] + acell[2] + acell[3]
aline2 = acell[4] + acell[5] + acell[6]
aline3 = acell[7] + acell[8] + acell[9]
acolumn1 = acell[1] + acell[4] + acell[7]
acolumn2 = acell[2] + acell[5] + acell[8]
acolumn3 = acell[3] + acell[6] + acell[9]
aall = aline1 + aline2 + aline3

acrossNum = aall % 10
azeroNum = ( aall - acrossNum ) / 10


acrossWin == Or( aline1== 3 , aline2== 3 , aline3== 3 , acolumn1== 3 , acolumn2== 3 , acolumn3== 3, adiagonal1== 3 , adiagonal2== 3 )
azeroWin == Or( aline1== 30 , aline2== 30 , aline3== 30 , acolumn1== 30 , acolumn2== 30 , acolumn3== 30 , adiagonal1== 30 , adiagonal2== 30 )

adraw = And(( acrossNum + azeroNum== 9 ) , Not(acrossWin) , Not(azeroWin))
agameFinished = Or(acrossWin , azeroWin , adraw)
deadlineCorrect = And(Input[10] >= height + 4 , Input[10] <= height + 6)
#dont touch input1
inputSigned = And(    inputCorrect , Or(And( Input[1] == 1 , sender == 100 , acrossNum == azeroNum ) , And( Input[1] == 10 , sender == 500 , acrossNum > azeroNum ))      )

#Final data condition
#s.add(   Or(And( inputSigned , deadlineCorrect , Not(agameFinished) ) , ( dataSize == 99 ))   )
dataOk=   And(Or(And( inputSigned , deadlineCorrect , Not(agameFinished) ) , ( dataSize == 99 )), sumOk)



#Transfer variables
diagonal1 = cell1 + cell5 + cell9
diagonal2 = cell3 + cell5 + cell7
line1 = cell1 + cell2 + cell3
line2 = cell4 + cell5 + cell6
line3 = cell7 + cell8 + cell9
column1 = cell1 + cell4 + cell7
column2 = cell2 + cell5 + cell8
column3 = cell3 + cell6 + cell9
all = line1 + line2 + line3

zeroNum = ( all - crossNum ) / 10
crossNum = all % 10

zeroWin = Or( line1== 30 , line2== 30 , line3== 30 , column1== 30 , column2== 30 , column3== 30 , diagonal1== 30 , diagonal2== 30 )
aliceAddr = 100
bobAddr = 500
crossWin = Or( line1== 3 , line2== 3 , line3== 3 , column1== 3 , column2== 3 , column3== 3, diagonal1== 3 , diagonal2== 3 )
timeout = Or(And( crossNum > zeroNum , height > deadline1 , recipient == aliceAddr ) , And( crossNum == zeroNum , height > deadline1 , recipient == bobAddr ))
win = Or( And( recipient == aliceAddr , crossWin ) , And( recipient == bobAddr ,zeroWin ) )

#Final transfer condition
s.add( Or(1==1) )



s.add(Or(bcell[1] == acell[1], And(bcell[1] == Input[1], Input[1] >= -1000000, dataOk)))
s.add(Or(bcell[2] == acell[2], And(bcell[2] == Input[2], Input[2] >= -1000000, dataOk)))
s.add(Or(bcell[3] == acell[3], And(bcell[3] == Input[3], Input[3] >= -1000000, dataOk)))
s.add(Or(bcell[4] == acell[4], And(bcell[4] == Input[4], Input[4] >= -1000000, dataOk)))
s.add(Or(bcell[5] == acell[5], And(bcell[5] == Input[5], Input[5] >= -1000000, dataOk)))
s.add(Or(bcell[6] == acell[6], And(bcell[6] == Input[6], Input[6] >= -1000000, dataOk)))
s.add(Or(bcell[7] == acell[7], And(bcell[7] == Input[7], Input[7] >= -1000000, dataOk)))
s.add(Or(bcell[8] == acell[8], And(bcell[8] == Input[8], Input[8] >= -1000000, dataOk)))
s.add(Or(bcell[9] == acell[9], And(bcell[9] == Input[9], Input[9] >= -1000000, dataOk)))
s.add(Or(bcell[10] == acell[10], And(bcell[10] == Input[10], Input[10] >= -1000000, dataOk)))
s.add(Or(bcell[11] == acell[11], And(bcell[11] == Input[11], Input[11] >= -1000000, dataOk)))
s.add(Or(bcell[11] == acell[12], And(bcell[12] == Input[12], Input[12] >= -1000000, dataOk)))



#Connection between states
s.add(cell1 == bcell[1], cell2 == bcell[2], cell3 == bcell[3], cell4 == bcell[4], cell5 == bcell[5], 
cell6 == bcell[6], cell7 == bcell[7], cell8 == bcell[8], cell9 == bcell[9])
	
#print win
	


ind = 0

f = open("/root/all/bin/python/log.txt", "w+")



while s.check() == sat:
  ind = ind +1
  print "Next:"
  print ind
  m = s.model()
  print m
  
  print "traversing model..." 
  #for d in m.decls():
	#print "%s = %s" % (d.name(), m[d])

  
  exit()
  f.write(str(m))
  f.write("\n\n")
  s.add(Or(cell1 != s.model()[cell1], cell2 != s.model()[cell2], cell3 != s.model()[cell3], cell4 != s.model()[cell4], cell5 != s.model()[cell5], cell6 != s.model()[cell6], cell7 != s.model()[cell7], cell8 != s.model()[cell8], cell9 != s.model()[cell9])) # prevent next model from using the same assignment as a previous model



print "Total solution number: "
print ind  

f.close()
 

  



