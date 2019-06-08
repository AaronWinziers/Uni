# Telegram-SudokuSolver Spezifikation

## Kommunikation

Der SudokuSolver kommuniziert über den Telegram Messenger. Hierzu wird für jede Instanz ein Telegram-Bot angelegt.
"TSSB1Bot" - "TSSB9Bot". Alle Bots befinden sich in der Gruppe "TrierSudokuSolvingGroup" 
(https://t.me/joinchat/HfzFUQ4h8PD3K3SoOhR5oA). Die Bots können dabei Nachrichten untereinander austauschen, 
indem sie dem Kommando: /fieldconfig ihre aktuelle Feldkonfiguration anfügen. Das /fieldconfig Kommando wird 
anschließend von den anderen Bots innerhalb der Gruppe gelesen und verarbeitet.

Für die Schnittstelle mit Camel wird ein weiterer Bot benötigt. Diesen stellt @TrierSudokuSolverBot 
(https://t.me/TrierSudokuSolverBot) dar. Die Camel Komponente benötigt lediglich den Telegram-Token und muss das 
Kommando /fieldconfig verarbeiten bzw. senden. Die Formatkonvertierung wird durch die Camel-Komponente realisiert.

## Nachrichtenformat

Im Unterschied zur Variante mittels TCP versteht der Bot auch Nachrichten, welche die gesamte 
Feldkonfiguration enthalten. Das Format ist dabei das gleiche, wie es bei der Initialisierung verwendet wird,
mit dem Zusatz, dass der Boxname als Präfix angefügt wird. Dies hat den Vorteil, dass weniger Nachrichten 
gesendet werden müssen und es nicht zu einer Überflutung des Chats kommt.

Format: BOX_XX,xy:value - Beispiel: BOX_A1,20:2,11:9

## Ergebnis

Sobald eine Box fertig ist, sendet sie ein letztes Mal die aktuelle Feldkonfiguration mittels: /fieldconfig. 
Anschließend wird das Kommando /finish in die Gruppe gesendet und der Inhalt der Box ausgegeben. 