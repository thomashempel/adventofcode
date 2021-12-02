import sys

data = map(lambda l: l.strip(), open(sys.argv[1], "r").readlines())
result = 0
last = int(data[0])

for line in data:
    if int(line) > last:
        result += 1
    last = int(line)

print(result)
