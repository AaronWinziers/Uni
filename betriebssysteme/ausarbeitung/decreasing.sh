#! /bin/bash
for i in {0..9}; do 
   date +%T > temp.csv
   echo $1 >> temp.csv
   echo $2 >> temp.csv
   for n in {21..12..-1}; do
      if [ $n -ge 20 ]; then
         time -f "%e" cp $1$(( 2 ** ($n % 20) ))GB.bin $2          2>> temp.csv
      elif [ $n -ge 10 ]; then
         time -f "%e" cp $1$(( 2 ** ($n % 10) ))MB.bin $2          2>> temp.csv
      else 
         time -f "%e" cp $1$(( 2 ** ($n) ))KB.bin $2               2>> temp.csv
      fi
   done
   rm $2*
   mv data.csv tempdata.csv
   paste -d, tempdata.csv temp.csv > data.csv
   rm temp.csv tempdata.csv
done
