import java.io.BufferedReader;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.URL;
import java.net.URLConnection;

import org.omg.CORBA.portable.InputStream;

public class IMDBimages {

	public static void main(String[] args) throws Exception {
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
//		String imageUrl = getImageURL(targets[0]);
//		String destinationFile = "mov" + String.format("%03d", (0 + 1)) + ".jpg";
//		System.out.println(imageUrl);
//		System.out.println(destinationFile);
		 for (int i = 0; i < 36; i++) {
		 String imageUrl = getImageURL(targets[i]);
		 String destinationFile = "mov" + String.format("%03d", (i + 1)) + ".jpg";
		 saveImage(imageUrl, destinationFile);
		 }
	}

	public static String getImageURL(String code) {
		String whole = "";
		try {
			URL game = new URL("http://www.imdb.com/title/" + code + "/");
			URLConnection connection = game.openConnection();
			BufferedReader in = new BufferedReader(
					new InputStreamReader(connection.getInputStream()));
			String inputLine;
			while ((inputLine = in.readLine()) != null) {
				whole += inputLine;
			}
			in.close();
		} catch (Exception e) {
			e.printStackTrace();
		}
		String url = whole.substring(whole.indexOf("poster"));
//		System.out.println(url);
		url = url.substring(url.indexOf("http"));
//		url = url.substring(url.indexOf("\"") + 1);
		url = url.substring(0, url.indexOf("\""));
		// while (desc.charAt(0)==' '){
		// desc=desc.substring(1);
		// }
		// while (desc.charAt(desc.length()-1)==' '){
		// desc=desc.substring(0,desc.length()-2);
		// }

		return url;
	}

	public static void saveImage(String imageUrl, String destinationFile)
			throws IOException {
		URL url = new URL(imageUrl);
		java.io.InputStream is = url.openStream();
		OutputStream os = new FileOutputStream(destinationFile);

		byte[] b = new byte[2048];
		int length;

		while ((length = is.read(b)) != -1) {
			os.write(b, 0, length);
		}

		is.close();
		os.close();
	}
}
