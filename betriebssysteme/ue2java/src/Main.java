public class Dice {

	private final int seiten = 6;
	private int ergebnis = 0;


	public void throwDice() {
		ergebnis = 1 + (int) (Math.random() * 6);
	}

	public int pips() {
		if (ergebnis == 0) {
			throwDice();
		}
		return ergebnis;
	}

	public static int pipsum(Dice d1, Dice d2) {
		return d1.pips() + d2.pips();
	}
}
