import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;

public class IMDBDirectors {
	public static void main(String[] args) {
		String[] targets = { "tt0848228", // avengers
				"tt2395427", // avenger-ultron
				"tt0458339", // capt amer
				"tt1843866", // capt amer-winter
				"tt0061578", // dirty dozen
				"tt0073195", // jaws
				"tt0120737", // lord of the rings
				"tt0903624", // hobbit
				"tt1298650", // Pirates (strange tides
				"tt0499549", // Avatar
				"tt0120338", // Titanic
				"tt0172495", // Gladiator
				"tt0133093", // Matrix
				"tt0109830", // Forrest Gump
				"tt1375666", // Inception
				"tt1853728", // Django
				"tt0361748", // Inglorious Basterds
				"tt0993846", // Wolf Of Wall Street
				"tt0816692", // Interstellar
				"tt2015381", // Guardians of the galaxy
				"tt0371746", // Iron man
				"tt0468569", // Dark night
				"tt1345836", // Dark night rises
				"tt1877832", // Xmen future past
				"tt0418279", // Transformers
				"tt0480249", // I am legend
				"tt0343818", // I robot
				"tt0119654", // Men in black
				"tt0120912", // Men in black 2
				"tt0116629", // Independance day
				"tt0319262", // Day after tomorrow
				"tt1190080", // 2012
				"tt0407304", // War of the worlds
				"tt0120616", // The mummy
				"tt0167190",// Hellboy

		};

		for (int i = 0; i < 35; i++) {
			targets[i] = get(targets[i]);
		}
		targets = writeDirectors(targets);

	}

	public static String get(String target) {
		try {
			URL game = new URL("http://www.imdb.com/title/" + target + "/");
			URLConnection connection = game.openConnection();
			target = "";
			BufferedReader in = new BufferedReader(
					new InputStreamReader(connection.getInputStream()));
			String inputLine;
			while ((inputLine = in.readLine()) != null) {
				target += inputLine;
			}
			in.close();
		} catch (Exception e) {
			e.printStackTrace();
		}

		return target;
	}

	public static String[] writeDirectors(String[] targets) {
		String[] names = new String[35];
		int temp = -1;
		try {
			BufferedWriter out = new BufferedWriter(new FileWriter("directors.txt"));
			BufferedWriter out2 = new BufferedWriter(new FileWriter("directs.txt"));
			for (int i = 0; i < 35; i++) {
				temp = -1;
				String director = targets[i].substring(targets[i].indexOf("Director"));
				targets[i] = director.substring(director.indexOf("href=\"/") + 12);
				targets[i] = targets[i].substring(0, targets[i].indexOf("?"));
				director = director.substring(0, director.indexOf("</span>"));
				String fName = director
						.substring(director.indexOf("itemprop=\"name\">") + 16);
				String lName = fName.substring(fName.indexOf(" ") + 1);
				fName = fName.substring(0, fName.indexOf(" "));
				names[i] = fName;
				for (int j = 0; j < i; j++) {
					if (fName.equals(names[j])) {
						temp = j;
						System.out.println(j+" and " + i);
						j=45;
					}
				}
				// System.out.println(director);
				// System.out.println(targets[i]);
				// System.out.println(lName);
				System.out.println(fName);
				if (temp == -1) {
					out.write("('dir" + String.format("%04d", (i + 1)) + "', '" + lName
							+ "', '" + fName + "', 'USA', 'male', '"
							+ (int) (Math.random() * 100 + 1900) + "-"
							+ (int) (Math.random() * 12 + 1) + "-"
							+ (int) (Math.random() * 27 + 1) + "'),\n");
					out2.write("('dir" + String.format("%04d", (i + 1)) + "', 'mov"
							+ String.format("%03d", (i + 1)) + "'),\n");
				} else {
					System.out.println("SKIP: " + fName + " with " + names[temp]);
					out2.write("('dir" + String.format("%04d", (temp + 1)) + "', 'mov"
							+ String.format("%03d", (i + 1)) + "'),\n");
				}

			}
			out.close();
			out2.close();
		} catch (IOException e) {
		}
		return targets;
	}
}
