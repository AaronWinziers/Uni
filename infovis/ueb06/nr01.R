#### Information Visualization - Assignment 6
library(MASS)
# first look at the data set
mtcars
# cyl, vs, am, gear and carb are categorial
mtcars$cyl
# mpg, disp, hp, drat, wt and qsec are numerical
mtcars$mpg
# get variables having at least interval scale (level of measurement) from mtcars
interval_mtcars = data.frame(mpg=mtcars$mpg, disp=mtcars$disp, hp=mtcars$hp, drat=mtcars$drat, wt=mtcars$wt, qsec=mtcars$qsec)
mpg=mtcars$mpg
disp=mtcars$disp
hp=mtcars$hp
drat=mtcars$drat
wt=mtcars$wt
qsec=mtcars$qsec
# a) Mean, median, quartiles (lower, upper), minimum, maximum
sapply(interval_mtcars, summary, na.rm=TRUE)
# b) One boxplot with all interval scale variables
boxplot(mpg, disp, hp, drat, wt, qsec,
main = "Boxplots for all interval scale variables",
names = c("Mpg", "Disp", "Hp", "Drat", "Wt", "Qsec"),
col = c("orange","red"),
border = "brown",
notch=FALSE
)
# c) Histograms for all interval scale variables in one graphic
dev.new()
par(mfrow=c(3, 2))
hist(mpg)
hist(disp)
hist(hp)
hist(drat)
hist(wt)
hist(qsec)
# d) Scatterplot matrix with all numerical variables
dev.new()
pairs(~mpg+disp+drat+wt+qsec+hp,data=mtcars,
main="Scatterplot matrix with all numerical variables")
# Nr02
dev.new()
clusters <- kmeans(interval_mtcars, 5)
interval_mtcars$cluster = clusters$cluster
parcoord(interval_mtcars, col=factor(interval_mtcars$cluster), var.label=TRUE)