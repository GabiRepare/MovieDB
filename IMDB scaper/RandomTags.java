import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

public class RandomTags {
	public static void main(String[] args) {
		try {
			BufferedWriter out = new BufferedWriter(new FileWriter("tags.txt"));
			for (int j = 0; j < 35; j++) {
				int temp1 = (int) (Math.random() * 20 + 1),
						temp2 = (int) (Math.random() * 20 + 1);
				if (temp1 == temp2) {
					if (temp1 == 21) {
						temp1 = 20;
					} else if (temp1 == 1) {
						temp1 = 2;
					} else {
						temp1 += 1;
					}
				}
				out.write("('top" + String.format("%03d", temp1) + "', 'mov"
						+ String.format("%03d", (j + 1)) + "', 'true'),\n");
				out.write("('top" + String.format("%03d", temp2) + "', 'mov"
						+ String.format("%03d", (j + 1)) + "', 'true'),\n");
			}
			out.close();
		} catch (IOException e) {
		}
	}
}
