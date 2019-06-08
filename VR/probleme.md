Probleme die aufgetreten sind bei der Entwicklung

# Spielerskalierung
* Spieler Scale lief dauernd auf 0
* Skalierung lief über Hand Distanz, aber sobald die Größe sich veränderte, änderte sich der Wert exponentiell
* Größe sprung hin und her gegen 1
* Gingen zurück auf die Ursprungsversion und haben die änderungen gedämpft
* Methode set hat nicht funktioniert, führte dazu dass wir anderes im Verdacht hatten

## Rechnung Varianten
* Player.transform.localscale \*= newDistance / initialdistance
* Player.transform.localscale \*= newDistance / (initialdistance \* Player.transform.localScale)
* Player.transform.localscale \*= newDistance / initialdistance
* Player.transform.localscale \*= ((newDistance / initialdistance) + 1) / 2

## Tools
Beim Skalierung wurden die Tools am Gürtel auch zu groß, und haben das sehen beeinträchtigt

Erst haben wir Vektoren von der Camera aus die Position der Tools skalieren können mit dem Skalierungsfaktor des Speilers.

Dann war das Problem dass die Tools auch an die Rotation des Kopfs des Spielers gebunden war, und damit nicht an dem "Gürtel" des Spielers fest hingen.



# Ecken Ziehen
Did some things, changed some stuff

# Flächen Ziehen


# Objekt Skalieren

Während dem Skalieren wurden die Positionen der Ecken des Mesches falsch berechnet, da die Skalierung des Objekts nicht brücksichtigt wurde
