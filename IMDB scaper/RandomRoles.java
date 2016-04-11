import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

public class RandomRoles {
	public static void main(String[] args) {
		try {
			BufferedWriter out = new BufferedWriter(new FileWriter("rpi.txt"));
			for (int i = 4; i < 35; i++) {
				//temp = "act" + String.format("%04d", (i + 1));
				out.write("('mov" + String.format("%03d", (i + 1)) + "', '" + "rol"
						+ String.format("%04d", 2 * (int) (Math.random() * 7 + 5))
						+ "'),\n");
				out.write("('mov" + String.format("%03d", (i + 1)) + "', '" + "rol"
						+ String.format("%04d", 2 * (int) (Math.random() * 7 + 5)-1)
						+ "'),\n");
			}
			out.close();
		} catch (IOException e) {
		}
	}
}
