import hashlib
import glob
import os
count = 0
for file in glob.glob("src/*"):
  hash = hashlib.md5(open(file).read()).hexdigest()
  newname = hash + "." + file.split(".")[-1]
  print file, newname
  os.rename(file, "src2/" + newname)
  count += 1

print count

