import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

public class RandomActors {
	public static void main(String[] args) {
		try {
			BufferedWriter out = new BufferedWriter(new FileWriter("role.txt"));
			String temp;
			int counter = 8;
			for (int i = 9; i < 16; i++) {
				temp = "act" + String.format("%04d", (i + 1));
				out.write("('rol" + String.format("%04d", (counter + 1)) + "', '" + "act"
						+ String.format("%04d", (i + 1)) + "', 'Chef', 'Head', 'male'),\n");
				out.write("('rol" + String.format("%04d", (counter + 2)) + "', '" + "act"
						+ String.format("%04d", (i + 1)) + "', 'Security guard', ' ', 'male'),\n");
				counter+=2;
			}
			out.close();
		} catch (IOException e) {
		}
	}
}
