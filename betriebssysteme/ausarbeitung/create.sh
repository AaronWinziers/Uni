#! /bin/bash
for n in {12..22}; do
   if [ $n -ge 20 ]; then
      dd if=/dev/urandom of=$((2 ** ($n % 20) ))GB.bin bs=1024 count=$(( 2 ** $n ))
   elif [ $n -ge 10 ]; then
      dd if=/dev/urandom of=$((2 ** ($n % 10) ))MB.bin bs=1024 count=$(( 2 ** $n ))
   else 
      dd if=/dev/urandom of=$((2 ** ($n) ))KB.bin bs=1024       count=$(( 2 ** $n ))
   fi
done
