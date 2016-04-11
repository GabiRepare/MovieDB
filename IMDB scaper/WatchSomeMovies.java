import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

public class WatchSomeMovies {

	public static void main(String[] args) {
		String[] users = { "user0001", "user0002", "user0003", "user0004", "user0005" };
		try {
			BufferedWriter out = new BufferedWriter(new FileWriter("watch.txt"));
			for (int i = 0; i < users.length; i++) {
				for (int j = 0; j < 35; j++) {
					// temp = "mov" + String.format("%03d", (i + 1));
					out.write("('" + users[i] + "', '" + "mov"
							+ String.format("%03d", (j + 1)) + "', '"
							+ (int) (Math.random() * 100 + 1900) + "-"
							+ (int) (Math.random() * 12 + 1) + "-"
							+ (int) (Math.random() * 27 + 1) + "', "
							+ (int) (Math.random() * 5 + 1) + "),\n");
					// out.write(get(temp, users[i]));
				}
			}
			out.close();
		} catch (IOException e) {
		}
	}
}