# We know each queen must be in a different row.
# So, we represent each queen by a single integer: the column position

import json

from z3 import *

Q = [ Int('Q_%i' % (i + 1)) for i in range(30) ]

# Each queen is in a column {1, ... 30 }
val_c = [ And(1 <= Q[i], Q[i] <= 30) for i in range(30) ]

# At most one queen per column
col_c = [ Distinct(Q) ]

# Diagonal constraint
diag_c = [ If(i == j,
              True,
              And(Q[i] - Q[j] != i - j, Q[i] - Q[j] != j - i))
           for i in range(30) for j in range(i) ]

solve(val_c + col_c + diag_c)