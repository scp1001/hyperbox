import json

from z3 import *

x = Int('x')
y = Int('y')
z = Bool('z')

z=x > 2 or x < 1, x > 2 or x < 1


solve(z)