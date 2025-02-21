/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	RichText,
	InspectorControls,
} from "@wordpress/block-editor";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

import {
	IntegerControl,
	PanelBody,
	PanelRow,
	TextControl,
} from "@wordpress/components";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();

	const onChangeContent = (newContent) => {
		setAttributes({ content: newContent });
	};

	const setQuestion = (index, question) => {
		const list = JSON.parse(JSON.stringify(attributes.list));
		list[index].question = question;
		setAttributes({ list });
	};

	const setResponse = (index, response) => {
		const list = JSON.parse(JSON.stringify(attributes.list));
		list[index].response = response;
		setAttributes({ list });
	};

	const addQuestionResponse = () => {
		const list = JSON.parse(JSON.stringify(attributes.list));
		list.push({
			index: attributes.list.length,
			question: "",
			response: "",
		});
		setAttributes({ list });
	}

	return (
		<>
			{/* <InspectorControls>
				<PanelBody title="Settings" initialOpen={true}>
					<PanelRow>
						<IntegerControl
							label="Question count"
							onChange={(count) => setAttributes({ count })}
							value={attributes.count}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls> */}
			<div {...blockProps}>
				<ul>
					{attributes.list.map((_, index) => (
						<li key={index}>
							{/* <RichText
								tagName="div"
								onChange={(question) =>
									setAttributes({ list: { [index]: { question } } })
								}
								allowedFormats={["core/bold", "core/italic"]}
								value={attributes.list[index].question}
								placeholder={__("❓ Write your question...")}
								className="question"
							/>
							<RichText
								tagName="div"
								onChange={(response) =>
									setAttributes({ list: { [index]: { response } } })
								}
								allowedFormats={["core/bold", "core/italic"]}
								value={attributes.list[index].response}
								placeholder={__("▶️ Write your response...")}
								className="response"
							/> */}

							<TextControl
								onChange={(question) => setQuestion(index, question)}
								value={attributes.list[index].question}
								placeholder={__("Question ?")}
							/>
							<TextControl
								onChange={(response) => setResponse(index, response)}
								value={attributes.list[index].response}
								placeholder={__("Response")}
								onKeyUp={(event) => {
									if (index === attributes.list.length - 1 && "Enter" === event.key) {
										addQuestionResponse()
									}
								}}
							/>

						</li>
					))}

					{/* <RichText
					tagName="p"
					onChange={onChangeContent}
					allowedFormats={["core/bold", "core/italic"]}
					value={attributes.content}
					placeholder={__("Write your text...")}
				/> */}
				</ul>

				<button onClick={addQuestionResponse}>
					{__("Add one question")}
				</button>

				{ attributes.list.length > 1 ? (<button
					onClick={() => {
						const list = JSON.parse(JSON.stringify(attributes.list));
						list.pop();
						setAttributes({ list });
					}}
				>
					{__("Delete last question/response...")}
				</button>) : <></> }

				{/* <p {...blockProps}>title is {attributes.title}</p> */}
			</div>
		</>
	);
}
